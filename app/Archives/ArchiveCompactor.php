<?php

namespace App\Archives;

class ArchiveCompactor
{
    protected $redis;

    public function __construct(RedisKeys $redis)
    {
        if ($redis->prefix() === '')
            throw new \RuntimeException('Refusing archive compaction without an application Redis prefix.');

        $this->redis = $redis;
    }

    /** A concurrent push/rewrite must never cause us to overwrite a different record. */
    public function replace($key, $index, $before, $after)
    {
        $prefix = $this->redis->prefix();
        if (strncmp($key, $prefix, strlen($prefix)) !== 0 || ! RedisKeys::isArchive(substr($key, strlen($prefix))))
            throw new \RuntimeException('Only this application’s event archive lists may be compacted.');

        if (ArchiveCodec::decode($before) !== ArchiveCodec::decode($after))
            throw new \RuntimeException('Archive replacement would change event history.');

        return (int) $this->redis->command(['EVAL', <<<'LUA'
local current = redis.call('LINDEX', KEYS[1], ARGV[1])
if not current or current ~= ARGV[2] then return 0 end
redis.call('LSET', KEYS[1], ARGV[1], ARGV[3])
return 1
LUA
            , 1, $key, $index, $before, $after]) === 1;
    }

    public function run($apply = false, $restore = false, $batch = 25, $limit = 0, callable $afterBatch = null)
    {
        if ($batch < 1 || $batch > 100 || $limit < 0)
            throw new \InvalidArgumentException('Invalid archive maintenance batch size or record limit.');

        $result = ['lists' => 0, 'records' => 0, 'candidates' => 0, 'changed' => 0, 'conflicts' => 0, 'before_bytes' => 0, 'after_bytes' => 0, 'saved_bytes' => 0];
        $prefix = $this->redis->prefix();

        foreach ($this->redis->scan($prefix) as $key) {
            if (! RedisKeys::isArchive(substr($key, strlen($prefix)))
                || $this->redis->command(['TYPE', $key]) !== 'list')
                continue;

            $result['lists']++;
            $length = (int) $this->redis->command(['LLEN', $key]);

            for ($start = 0; $start < $length; $start += $batch) {
                $end = min($start + $batch - 1, $length - 1);
                $records = $this->redis->command(['LRANGE', $key, $start, $end]);

                foreach ($records as $offset => $before) {
                    if ($limit && $result['records'] >= $limit)
                        return $result;

                    $after = $restore ? ArchiveCodec::decode($before) : ArchiveCodec::encode($before);
                    $result['records']++;
                    $result['before_bytes'] += strlen($before);
                    $result['after_bytes'] += strlen($after);

                    if ($before === $after)
                        continue;

                    $result['candidates']++;
                    if ($apply) {
                        if ($this->replace($key, $start + $offset, $before, $after)) {
                            $result['changed']++;
                            $result['saved_bytes'] += strlen($before) - strlen($after);
                        } else {
                            $result['conflicts']++;
                        }
                    }
                }

                if ($afterBatch)
                    $afterBatch($result);
            }
        }

        return $result;
    }
}

<?php

namespace App\Cache;

use App\Archives\RedisKeys;
use Illuminate\Cache\RedisStore;
use RuntimeException;

class HistorySafeRedisStore extends RedisStore
{
    public function flush()
    {
        if ($this->prefix === '')
            throw new RuntimeException('Refusing to clear Redis without a cache prefix: event history must be preserved.');

        $redis = new RedisKeys($this->connection());
        $clientPrefix = $redis->prefix();
        $keys = [];

        foreach ($redis->scan($clientPrefix.$this->prefix) as $key) {
            // Protect history even if an old deployment assigned cache the same database/prefix.
            $logicalKey = substr($key, strlen($clientPrefix));
            if (preg_match('/^(?:gig|user|song):[0-9]+:/', $logicalKey))
                continue;

            $keys[] = $key;
            if (count($keys) === 100) {
                $this->removeKeys($redis, $keys);
                $keys = [];
            }
        }

        if ($keys)
            $this->removeKeys($redis, $keys);

        return true;
    }

    protected function removeKeys(RedisKeys $redis, array $keys)
    {
        try {
            $redis->command(array_merge(['UNLINK'], $keys));
        } catch (RuntimeException $e) {
            // Redis < 4 has no UNLINK; still delete only bounded batches of cache keys.
            if (stripos($e->getMessage(), 'unknown command') === false)
                throw $e;

            $redis->command(array_merge(['DEL'], $keys));
        }
    }
}

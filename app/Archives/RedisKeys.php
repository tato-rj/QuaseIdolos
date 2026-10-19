<?php

namespace App\Archives;

use Illuminate\Redis\Connections\Connection;
use Predis\ClientInterface;
use RuntimeException;

/** Raw maintenance commands use physical keys returned by SCAN, without double prefixing. */
class RedisKeys
{
    protected $client;
    protected $prefix;

    public function __construct(Connection $connection)
    {
        $this->client = $connection->client();

        if ($this->client instanceof ClientInterface) {
            if ($this->client->getConnection() instanceof \Predis\Connection\AggregateConnectionInterface)
                throw new RuntimeException('Redis maintenance requires a standalone connection, not a cluster/replication aggregate.');

            $processor = $this->client->getOptions()->prefix;
            $this->prefix = $processor ? $processor->getPrefix() : '';
        } elseif ($this->client instanceof \Redis) {
            if ($this->client->getOption(\Redis::OPT_SERIALIZER) !== \Redis::SERIALIZER_NONE
                || (defined('Redis::OPT_COMPRESSION') && $this->client->getOption(\Redis::OPT_COMPRESSION) !== \Redis::COMPRESSION_NONE))
                throw new RuntimeException('Raw Redis maintenance requires client serialization/compression to be disabled.');

            $this->prefix = (string) $this->client->getOption(\Redis::OPT_PREFIX);
        } else {
            throw new RuntimeException('Redis maintenance requires a standalone Predis or PhpRedis connection.');
        }
    }

    public function prefix()
    {
        return $this->prefix;
    }

    public function command(array $arguments)
    {
        if ($this->client instanceof ClientInterface) {
            $result = $this->client->executeRaw($arguments, $error);
            if ($error)
                throw new RuntimeException('Redis maintenance command failed: '.$result);

            return $result;
        }

        $this->client->clearLastError();
        $result = $this->client->rawCommand(...$arguments);
        if ($this->client->getLastError())
            throw new RuntimeException('Redis maintenance command failed: '.$this->client->getLastError());

        return $result;
    }

    public function scan($literalPrefix, $batch = 100)
    {
        $pattern = strtr($literalPrefix, ['\\' => '\\\\', '*' => '\\*', '?' => '\\?', '[' => '\\[', ']' => '\\]']).'*';
        $cursor = '0';

        do {
            [$cursor, $keys] = $this->command(['SCAN', $cursor, 'MATCH', $pattern, 'COUNT', $batch]);
            foreach ($keys as $key)
                yield $key;
        } while ((string) $cursor !== '0');
    }

    public static function isArchive($logicalKey)
    {
        return (bool) preg_match('/^(?:gig:[0-9]+:(?:participants|setlist|ratings|winner)|user:[0-9]+:(?:gigs|songRequests|ratings)|song:[0-9]+:(?:songRequests|ratings))$/D', $logicalKey);
    }
}

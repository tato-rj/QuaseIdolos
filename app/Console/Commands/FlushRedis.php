<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Archives\RedisKeys;
use Illuminate\Support\Facades\Redis;

class FlushRedis extends Command
{
    protected $signature = 'redis:flush {namespace} {--confirm}';
    protected $description = 'This command clears all redis records related to a given namespace';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (production())
            return $this->info('You can\'t do this here.');
        
        $confirm = $this->option('confirm');
        $namespace = $this->argument('namespace');

        if (testing() || $confirm || $this->confirm('This will delete all records within the ' . $namespace . ' namespace. Are you sure?'))
            $this->clear($namespace);
    }

    public function clear($namespace)
    {
        $redis = new RedisKeys(Redis::connection('default'));
        if ($namespace === '' || $namespace !== $redis->prefix())
            throw new \RuntimeException('Only the configured application Redis prefix may be cleared.');

        $keys = [];
        foreach ($redis->scan($namespace) as $key) {
            $keys[] = $key;
            if (count($keys) === 100) {
                $redis->command(array_merge(['DEL'], $keys));
                $keys = [];
            }
        }

        if ($keys)
            $redis->command(array_merge(['DEL'], $keys));

        $this->info('All keys under ' . $namespace . ' have cleared');
    }
}

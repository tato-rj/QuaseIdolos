<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $confirm = $this->option('confirm');
        $namespace = $this->argument('namespace');

        if (testing() || $confirm || $this->confirm('This will delete all records within the ' . $namespace . ' namespace. Are you sure?'))
            $this->clear($namespace);
    }

    public function clear($namespace)
    {
        exec('redis-cli --scan --pattern '.$namespace.'* | xargs redis-cli unlink');
        $this->info('All keys under ' . $namespace . ' have cleared');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the laravel.log file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        exec('sudo truncate -s 0 storage/logs/laravel.log');

        $this->info('The log file has been cleared.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TruncateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:table {table}';
    protected $devTables = ['gigs', 'song_requests', 'ratings', 'participants', 'favorites'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a given database';

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
     * @return int
     */
    public function handle()
    {
        $table = $this->argument('table');

        if ($table == 'dev') {
            if ($this->confirm('This will reset the following tables: '.implode(', ', $this->devTables).'. Tem certeza?')) {
                foreach ($this->devTables as $table) {
                    \DB::table($table)->truncate();
                }

                return $this->info('All dev tables have been cleared');   
            } else {
                return;
            }
        }

        if (! in_array($table, $this->devTables))
            return $this->error('You can\'t clear this table');

        if ($this->confirm('Are you sure you want to reset the '.$table.' table?')) {
            \DB::table($table)->truncate();
            return $this->info('The table has been cleared');
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gig;

class CloseGigs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gigs:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closes any opened gigs over the closing time';

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
        foreach (Gig::live()->get() as $gig) {
            if ($gig->shouldFinish())
                $gig->close(true);
        }

        $this->info('All gigs have been closed.');
    }
}

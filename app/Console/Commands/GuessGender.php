<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GuessGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gender:guess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Guess the gender of a user based on the first name';

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
        foreach (User::whereNull('gender')->take(5)->get() as $user) {
            $user->update(['gender' => gender($user->first_name)->guess()]);
        }

        $this->info('All genders have been assigned');
    }
}

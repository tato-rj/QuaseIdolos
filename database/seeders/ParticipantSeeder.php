<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Gig, User};

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::guests()->inRandomOrder()->get() as $user) {
            $user->join(Gig::live()->orPast()->inRandomOrder()->first());
        }
    }
}

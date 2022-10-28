<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Admin, Gig};

class GigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gig::create([
            'name' => 'Big Ben',
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 40,
            'songs_limit_per_user' => 2,
            'date' => now()->copy()->subDays(4),
            'starts_at' => now()->copy()->subDays(4),
            'ends_at' => now()->copy()->subDays(4)->addMinutes(347)
        ]);

        Gig::create([
            'name' => 'Big Ben',
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 40,
            'songs_limit_per_user' => 2,
            'is_live' => true,
            'date' => now()->copy()->now(),
        ]);
    }
}

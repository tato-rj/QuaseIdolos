<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Admin, Gig, Venue};

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
            'venue_id' => Venue::byName('Big Ben')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 40,
            'songs_limit_per_user' => 2,
            'has_ratings' => true,
            'scheduled_for' => now()->addDays(4),
        ]);

        Gig::create([
            'venue_id' => Venue::byName('Big Ben')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'songs_limit_per_user' => 2,
            'has_ratings' => true,
            'is_live' => true,
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        Gig::create([
            'venue_id' => Venue::byName('L\'Oreal')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 40,
            'songs_limit_per_user' => 10,
            'has_ratings' => true,
            'is_live' => true,
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        Gig::create([
            'venue_id' => Venue::byName('L\'Oreal')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'songs_limit_per_user' => 2,
            'has_ratings' => true,
            'scheduled_for' => now()->subMonth(),
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->subMonth()->addMinutes(347)
        ]);
    }
}

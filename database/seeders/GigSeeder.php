<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Admin, Gig, Venue, Set};

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
            'starting_time' => '21:00',
            'scheduled_for' => now()->addDays(4),
        ]);

        $liveGig = Gig::create([
            'venue_id' => Venue::byName('Big Ben')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'set_limit' => 4,
            'has_ratings' => true,
            'is_live' => true,
            'starting_time' => '21:30',
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        Set::new($liveGig);

        foreach (Admin::musicians()->get() as $musician) {
            $liveGig->musicians()->save($musician);
        }

        Gig::create([
            'venue_id' => Venue::byName('Big Ben')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 30,
            'songs_limit_per_user' => 1,
            'has_ratings' => true,
            'starting_time' => '21:00',
            'scheduled_for' => now()->addMonth(),
        ]);

        Gig::create([
            'venue_id' => Venue::byName('L\'Oreal')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'songs_limit_per_user' => 2,
            'has_ratings' => true,
            'starting_time' => '17:00',
            'scheduled_for' => now()->subMonth(),
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->subMonth()->addMinutes(347)
        ]);

        Gig::create([
            'venue_id' => Venue::byName('L\'Oreal')->id,
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'password' => '1234',
            'songs_limit' => 40,
            'songs_limit_per_user' => 10,
            'has_ratings' => true,
            'is_live' => true,
            'is_private' => true,
            'starting_time' => '20:00',
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        foreach(Venue::inRandomOrder()->get() as $venue) {
            for ($i=0; $i < rand(1,5); $i++) { 
                $past = now()->subDays(1,500);
                $future = now()->addDays(1,60);
                $choice = rand(0,1);

                Gig::factory()->create([
                    'venue_id' => $venue,
                    'scheduled_for' => [$past, $future][$choice],
                    'songs_limit' => rand(10,20),
                    'starts_at' => $choice ? null : $past,
                    'ends_at' => $choice ? null : $past
                ]);
            }
        }
    }
}

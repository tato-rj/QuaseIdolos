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
            'description' => 'O Big Ben é um evento que realizamos de Segunda à Sábado a partir dat 19:00. Venha cantar e se divertir com agente!',
            'songs_limit_per_user' => 2,
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
            'has_ratings' => true,
            'scheduled_for' => now()->copy()->subDays(4),
            'starts_at' => now()->copy()->subDays(4),
            'ends_at' => now()->copy()->subDays(4)->addMinutes(347)
        ]);

        Gig::create([
            'name' => 'Big Ben',
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'description' => 'O Big Ben é um evento que realizamos de Segunda à Sábado a partir dat 19:00. Venha cantar e se divertir com agente!',
            'songs_limit_per_user' => 2,
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
            'has_ratings' => true,
            'is_live' => true,
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        Gig::create([
            'name' => 'L\'Oreal',
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 40,
            'songs_limit_per_user' => 10,
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
            'has_ratings' => true,
            'is_live' => true,
            'scheduled_for' => now(),
            'starts_at' => now()
        ]);

        Gig::create([
            'name' => 'Big Ben',
            'creator_id' => Admin::superAdmin()->first()->user->id,
            'songs_limit' => 10,
            'description' => 'O Big Ben é um evento que realizamos de Segunda à Sábado a partir dat 19:00. Venha cantar e se divertir com agente!',
            'songs_limit_per_user' => 2,
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
            'has_ratings' => true,
            'is_live' => true,
            'scheduled_for' => now()->subMonth(),
            'starts_at' => now()
        ]);
    }
}

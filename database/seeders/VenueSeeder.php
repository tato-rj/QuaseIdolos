<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Venue::create([
            'name' => 'Big Ben',
            'description' => 'O Big Ben é um evento que realizamos de Segunda à Sábado a partir dat 19:00. Venha cantar e se divertir com agente!',
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
        ]);

        Venue::create([
            'name' => 'L\'Oreal',
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
        ]);
    }
}

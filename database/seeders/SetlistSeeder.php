<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Setlist, Song, User};

class SetlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<40; $i++) { 
            Setlist::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id,
                'finished_at' => now()->copy()->subDays(rand(0, 180))
            ]);
        }

        for ($i=0; $i<5; $i++) { 
            Setlist::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id,
                'order' => Setlist::waiting()->count()
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Favorite, Song, User};

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<10; $i++) { 
            Favorite::firstOrCreate([
                'user_id' => User::inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id
            ]);
        }
    }
}

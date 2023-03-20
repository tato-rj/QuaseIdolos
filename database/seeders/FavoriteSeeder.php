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
        Favorite::create([
            'user_id' => User::first()->id,
            'song_id' => Song::where('name', 'Rolling in the Deep')->first()->id
        ]);

        Favorite::create([
            'user_id' => User::first()->id,
            'song_id' => Song::where('name', 'Sozinho')->first()->id
        ]);

        Favorite::create([
            'user_id' => User::first()->id,
            'song_id' => Song::where('name', 'All My Loving')->first()->id
        ]);

        for ($i=0; $i<10; $i++) { 
            Favorite::firstOrCreate([
                'user_id' => User::where('id', '!=', 1)->inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id
            ]);
        }
    }
}

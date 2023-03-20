<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Song, Artist, Genre};
use App\Tools\DummyText\LoremIpsum;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Artist::all() as $artist) {
                for ($i=0; $i < rand(6,40); $i++) { 
                        Song::firstOrCreate([
                                'artist_id' => $artist->id,
                                'name' => (new LoremIpsum)->wordsBetween(2,3),
                        ], [
                                'genre_id' => Genre::inRandomOrder()->first()->id,
                                'duration' => rand(2,6),
                                'bpm' => rand(40,160),
                                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24)
                        ]);
                }

        }

        Song::create([
                'name' => 'Rolling in the Deep',
                'artist_id' => Artist::byName('Adele')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '1c8gk2PeTE04A1pIDH9YMk'
        ]);

        Song::create([
                'name' => 'Sozinho',
                'artist_id' => Artist::byName('Caetano Veloso')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '02a8cGumnKuEPgoCzmalJp'
        ]);
        
        Song::create([
                'name' => 'All My Loving',
                'artist_id' => Artist::byName('The Beatles')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '4joiWvli4qJVEW6qZV2i2J'
        ]);
    }
}

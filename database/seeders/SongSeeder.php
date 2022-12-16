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
                        Song::create([
                                'artist_id' => $artist->id,
                                'genre_id' => Genre::inRandomOrder()->first()->id,
                                'name' => (new LoremIpsum)->wordsBetween(2,3),
                                'duration' => rand(2,6),
                                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24)]);
                }

        }
    }
}

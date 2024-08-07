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
        Song::create([
                'name' => 'Rolling in the Deep',
                'artist_id' => Artist::byName('Adele')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '1c8gk2PeTE04A1pIDH9YMk'
        ]);

        Song::create([
                'name' => 'Sozinho',
                'artist_id' => Artist::byName('Caetano Veloso')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '02a8cGumnKuEPgoCzmalJp'
        ]);
        
        Song::create([
                'name' => 'All My Loving',
                'artist_id' => Artist::byName('The Beatles')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '4joiWvli4qJVEW6qZV2i2J'
        ]);

        
        Song::create([
                'name' => 'Enter Sandman',
                'artist_id' => Artist::byName('Metallica')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '3VqHuw0wFlIHcIPWkhIbdQ'
        ]);

        
        Song::create([
                'name' => 'Nothing Else Matters',
                'artist_id' => Artist::byName('Metallica')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '2CtemffYhT0DJWcT1XW047'
        ]);

        Song::create([
                'name' => 'Deixa a Vida Me Levar',
                'artist_id' => Artist::byName('Zeca Pagodinho')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '3ADuEIn09NAZIBgpYY3IsE'
        ]);

        Song::create([
                'name' => 'Verdade',
                'artist_id' => Artist::byName('Zeca Pagodinho')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '2Hw2kl2Vkthv8JMRKyQkCU'
        ]);

        Song::create([
                'name' => 'Amor Perfeito',
                'artist_id' => Artist::byName('Babado Novo')->id,
                'genre_id' => Genre::inRandomOrder()->first()->id,
                'duration' => rand(2,6),
                'bpm' => rand(40,160),
                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24),
                'spotify_id' => '0ReupwT7wyLIbdsk0KLxpX'
        ]);
        
        foreach (Artist::all() as $artist) {
                for ($i=0; $i < rand(6,40); $i++) { 
                        Song::firstOrCreate([
                                'artist_id' => $artist->id,
                                'name' => (new LoremIpsum)->wordsBetween(2,3),
                        ], [
                                'genre_id' => Genre::inRandomOrder()->first()->id,
                                'duration' => rand(2,6),
                                'bpm' => rand(40,160),
                                'preview_url' => 'https://p.scdn.co/mp3-preview/d2d7e717c72a4fa08b3a8b22722c7369e8aa587d?cid=7d8b6533ad544266b94de9e3956a8544',
                                'lyrics' => (new LoremIpsum)->paragraphsBetween(4,24)
                        ]);
                }

        }
    }
}

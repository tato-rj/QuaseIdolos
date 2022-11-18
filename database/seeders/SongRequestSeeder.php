<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{SongRequest, Song, User, Gig};

class SongRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->pastSongRequests();
    }

    public function pastSongRequests()
    {
        for ($i=0; $i<mt_rand(40,50); $i++) { 
            SongRequest::create([
                'gig_id' => Gig::first()->id,
                'user_id' => User::guests()->inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id,
                'order' => SongRequest::waiting()->count(),
                'finished_at' => now()->copy()->subDays(rand(0, 180))
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{SongRequest, Song, Participant, Gig};

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
        foreach (Participant::guests()->inRandomOrder()->get() as $participant) {
            $gigs = Gig::live()->orPast()->inRandomOrder()->get();

            foreach ($gigs as $gig) {
                if ($gig->songRequestsLeft() > 2) {
                    $songRequest = SongRequest::create([
                        'gig_id' => $gig->id,
                        'user_id' => $participant->user->id,
                        'song_id' => Song::inRandomOrder()->first()->id,
                        'order' => SongRequest::forGig($gig)->waiting()->count(),
                        'was_recommended' => rand(0,1),
                        'finished_at' => $gig->songRequestsLeft() < 6 ? $gig->starts_at->addMinutes(rand(30,240)) : null
                    ]);
                }
            }
        }
    }
}

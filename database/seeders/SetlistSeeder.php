<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Setlist, Song, User, Gig};

class SetlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->pastSetlists();
        $this->currentSetlists();
    }

    public function pastSetlists()
    {
        for ($i=0; $i<40; $i++) { 
            Setlist::create([
                'gig_id' => Gig::first()->id,
                'user_id' => User::guests()->inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id,
                'order' => Setlist::waiting()->count(),
                'finished_at' => now()->copy()->subDays(rand(0, 180))
            ]);
        }
    }

    public function currentSetlists()
    {
        for ($i=0; $i<5; $i++) { 
            Setlist::create([
                'gig_id' => Gig::last()->id,
                'user_id' => User::guests()->inRandomOrder()->first()->id,
                'song_id' => Song::inRandomOrder()->first()->id,
                'order' => Setlist::waiting()->count()
            ]);
        }
    }
}

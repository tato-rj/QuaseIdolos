<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{SongRequest, User, Gig};

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Gig::past()->get() as $gig) {
            foreach ($gig->setlist as $songRequest) {
                $gig->participants()
                    ->inRandomOrder()
                    ->take(rand(2,40))
                    ->get()
                    ->each->rate($songRequest, randomFromArray([1,2,3,4,5]));
            }

            if ($winner = $gig->ranking()->ratings->first())
                $gig->update(['winner_id' => $winner->songRequest->id]);
        }
    }
}

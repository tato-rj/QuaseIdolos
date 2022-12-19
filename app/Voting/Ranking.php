<?php

namespace App\Voting;

use App\Models\{SongRequest, Song, Rating, Gig, Venue};

class Ranking
{
	protected $votes, $uniqueVotes;

    public function mock()
    {
        $user = auth()->user();

        $gig = Gig::factory()->live()->make(['venue_id' => 1, 'name' => ucfirst(faker()->word)]);

        $gig->venue = Venue::factory()->make();

        $songRequest = SongRequest::factory()->make([
            'gig_id' => 1, 
            'user_id' => $user, 
            'song_id' => Song::inRandomOrder()->first(),
            'created_at' => now()
        ]);

        $songRequest->gig = $gig;

        $votes = Rating::factory()->count(2)
                                  ->make(['user_id' => $user, 'song_request_id' => $songRequest])
                                  ->each(function($item) use ($songRequest) {
                                        $item->songRequest = $songRequest;
                                    });

        return $this->getVotes($votes);
    }

	public function getVotes($votes)
	{
        $this->votes = $votes;
        $this->uniqueVotes = $votes->groupBy('user_id');

        return $this;
	}

	public function create()
	{
	    $results = collect();

        $results->totalCount = $this->votes->count();

        $results->votersCount = $this->uniqueVotes->count();

        $ratings = collect();

        $this->votes->groupBy('song_request_id')->map(function($item, $index) use ($ratings) {
        	$entry = collect();
            $entry->songRequest = $item->first()->songRequest;
            $entry->average = $item->first()->songRequest->score(true);
            $entry->count = $item->count();

            $ratings->push($entry);
        });

        $results->ratings = $ratings->sortByDesc('average')->values();

        $results->winner = $ratings->first() ? $ratings->first()->songRequest : null;

        return $results;
	}
}
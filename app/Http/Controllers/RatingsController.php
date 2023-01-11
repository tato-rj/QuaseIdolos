<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{SongRequest, Rating};
use App\Events\ScoreSubmitted;

class RatingsController extends Controller
{
    public function index()
    {
        $songRequests = SongRequest::forGigTonight(auth()->user()->liveGig)->completed()->rateable()->latest()->get();

        return view('pages.ratings.index', compact('songRequests'));
    }

    public function user()
    {
        $collection = auth()->user()->ratings;

        $totalCount = $collection->count();

        $ratings = collect();

        $collection->groupBy('song_request_id')->map(function($item, $index) use ($ratings) {
            $entry = collect();
            $entry->songRequest = $item->first()->songRequest;
            $entry->average = $item->first()->songRequest->score(true);
            $entry->count = $item->count();
            $entry->created_at = $item->first()->created_at;

            $ratings->push($entry);
        });

        $ratings = $ratings->sortByDesc('average')->values();

        return view('pages.ratings.user.index', compact(['ratings', 'totalCount']));
    }

    public function live()
    {
        $timer = 10;
        $ratings = auth()->user()->liveGig->ratings->reverse()->groupBy('song_request_id');

        return view('pages.ratings.live.index', compact('timer'));
    }

    public function votes(Request $request)
    {
        $timer = $request->timer;
        $ratings = auth()->user()->liveGig->ratings->reverse()->groupBy('song_request_id');

        return view('pages.ratings.live.votes', compact(['ratings', 'timer']))->render();
    }

    public function store(Request $request, SongRequest $songRequest)
    {
        $this->authorize('create', [Rating::class, $songRequest]);

        $request->validate(['score' => 'required|integer']);

        $rating = auth()->user()->rate($songRequest, $request->score);

        try {
            ScoreSubmitted::dispatch($rating);   
        } catch (\Exception $e) {
            //
        }

        return $rating->score;
    }

    public function candidate(Request $request)
    {
        $songRequest = SongRequest::findOrFail($request->songRequestId);
        
        return view('pages.ratings.row', compact('songRequest'));
    }
}

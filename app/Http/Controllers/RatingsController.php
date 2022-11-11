<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SongRequest;
use App\Events\ScoreSubmitted;

class RatingsController extends Controller
{
    public function index()
    {
        $songRequests = SongRequest::forGigTonight(auth()->user()->liveGig())->completed()->rateable()->latest()->get();

        return view('pages.ratings.index', compact('songRequests'));
    }

    public function show()
    {
        return view('pages.ratings.show.index');
    }

    public function gig()
    {
        return view('pages.ratings.gig.index');
    }

    public function ranking()
    {
        $collection = auth()->user()->liveGig()->ratings;

        $totalCount = $collection->count();

        $ratings = collect();

        $collection->groupBy('song_request_id')->map(function($item, $index) use ($ratings) {
            $rating = collect([
                'songRequest' => $item->first()->songRequest,
                'average' => round($item->avg('score')),
                'count' => $item->count()
            ]);

            $ratings->push($rating);
        });

        $ratings = $ratings->sortByDesc('average')->values();

        return view('pages.ratings.gig.ranking', compact(['ratings', 'totalCount']));
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

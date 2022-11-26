<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{SongRequest, Rating};
use App\Events\ScoreSubmitted;
use App\Mail\Users\WinnerEmail;

class RatingsController extends Controller
{
    public function index()
    {
        $songRequests = SongRequest::forGigTonight(auth()->user()->liveGig())->completed()->rateable()->latest()->get();

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

        return view('pages.ratings.live.index', compact('timer'));
    }

    public function votes(Request $request)
    {
        $timer = $request->timer;
        // $results = auth()->user()->liveGig()->ranking();

        // $totalCount = $results->totalCount;
        // $ratings = $results->ratings;

        $ratings = auth()->user()->liveGig()->ratings->reverse();
        $votersCount = $ratings->groupBy('user_id')->count();

        return view('pages.ratings.live.votes', compact(['ratings', 'votersCount', 'timer']))->render();
    }

    public function winner()
    {
        $gig = auth()->user()->liveGig();
        $ranking = $gig->ranking();

        if ($ranking->ratings->isEmpty())
            return back()->with('error', 'Esse evento ainda não tem nenhum voto');

        $winner = $ranking->ratings->first();

        if (! $gig->winner()->exists())
            \Mail::to($winner->songRequest->user->email)->queue(new WinnerEmail($winner->songRequest));

        $gig->winner()->associate($winner->songRequest)->save();

        return view('pages.ratings.winner.index', compact(['ranking', 'winner']));
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

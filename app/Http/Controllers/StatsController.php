<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Genre, Gig, SongRequest, Song, User};
use App\Tools\ChartJS\Chart;

class StatsController extends Controller
{
    public function gigs(Request $request)
    {
        if (! $request->wantsJson())
            return view('pages.statistics.gig.index');

        $from = $request->from ? carbon(datePtToUs($request->from)) : now()->subYear();
        $to = $request->to ? carbon(datePtToUs($request->to)) : now();

        $data = (new Chart)->for($request->model)->date($request->column)
                              ->between($from, $to)
                              ->get($request->group_by ?? 'monthly');

        return response()->json([
            'labels' => $data->pluck('label'),
            'data' => $data->pluck('count')
        ]);
    }

    public function songs(Request $request)
    {
        $ranking = Song::withCount('songRequests')->orderBy('song_requests_count', 'DESC')->take(10)->get();

        return view('pages.statistics.songs.index', compact(['ranking']));
    }

    public function artists(Request $request)
    {
        $ranking = Artist::withCount('songRequests')->orderBy('song_requests_count', 'DESC')->take(10)->get();

        return view('pages.statistics.artists.index', compact(['ranking']));
    }

    public function genres(Request $request)
    {
        $ranking = Genre::withCount('songRequests')->orderBy('song_requests_count', 'DESC')->take(10)->get();

        return view('pages.statistics.genres.index', compact(['ranking']));
    }

    public function users(Request $request)
    {
        $ranking = User::withCount('songRequests')->orderBy('song_requests_count', 'DESC')->take(10)->get();

        return view('pages.statistics.users.index', compact(['ranking']));
    }
}

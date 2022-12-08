<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Genre, Gig};
use App\Tools\ChartJS\Chart;

class StatsController extends Controller
{
    public function gigs(Request $request)
    {
        if (! $request->wantsJson())
            return view('pages.stats.gig.index');

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

    public function artists(Request $request)
    {
        $rankingBySongs = Artist::withCount('songs')->orderBy('songs_count', 'DESC')->take(9)->get();

        return view('pages.stats.artists.index', compact(['rankingBySongs']));
    }

    public function genres(Request $request)
    {
        $rankingBySongs = Genre::withCount('songs')->orderBy('songs_count', 'DESC')->take(9)->get();

        return view('pages.stats.genres.index', compact(['rankingBySongs']));
    }
}

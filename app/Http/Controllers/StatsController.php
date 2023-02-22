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
        if ($request->wantsJson()) {
            $ranking = SongRequest::betweenDates(datePtToUs($request->from), datePtToUs($request->to))->getRankingBy('song_id');
            return view('pages.statistics.songs.table', compact('ranking'))->render();
        }

        return view('pages.statistics.songs.index');
    }

    public function artists(Request $request)
    {
        if ($request->wantsJson()) {
            $ranking = SongRequest::betweenDates(datePtToUs($request->from), datePtToUs($request->to))->getRankingBy('song.artist_id');
            return view('pages.statistics.artists.table', compact('ranking'))->render();
        }

        return view('pages.statistics.artists.index');
    }

    public function genres(Request $request)
    {
        if ($request->wantsJson()) {
            $ranking = SongRequest::betweenDates(datePtToUs($request->from), datePtToUs($request->to))->getRankingBy('song.genre_id');
            return view('pages.statistics.genres.table', compact('ranking'))->render();
        }

        return view('pages.statistics.genres.index');
    }

    public function users(Request $request)
    {
        if ($request->wantsJson()) {    
            switch ($request->chart) {
                case 'gender':
                    return response()->json([
                        'labels' => ['Feminino', 'Masculino'],
                        'data' => [User::female()->count(), User::male()->count()],
                        'colors' => ['#ec4899', '#0ea5e9'],
                    ]);
                    break;

                case 'login':
                    return response()->json([
                        'labels' => ['Manual', 'Facebook', 'Google'],
                        'data' => [User::withoutSocialAccounts()->count(), User::withSocialAccount('facebook')->count(), User::withSocialAccount('google')->count()],
                        'colors' => ['#f2cd3d', '#4267b2', '#ea4335']
                    ]);
                    break;
                
                default:
                    $ranking = SongRequest::betweenDates(datePtToUs($request->from), datePtToUs($request->to))->getRankingBy('user_id');
                    return view('pages.statistics.users.table', compact('ranking'))->render();
                    break;
            }
        }
        
        return view('pages.statistics.users.index');
    }
}

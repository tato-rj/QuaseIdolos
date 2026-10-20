<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{SongRequest, User};
use App\Tools\ChartJS\Chart;
use App\Http\Requests\StatisticsRequest;

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

    public function songs(StatisticsRequest $request)
    {
        if ($request->wantsJson()) {
            $limit = $request->rankingLimit();
            $ranking = SongRequest::betweenDates($request->from, $request->to)->getRankingBy('song_id', $limit);
            return view('pages.statistics.songs.table', compact('ranking', 'limit'))->render();
        }

        return view('pages.statistics.songs.index');
    }

    public function artists(StatisticsRequest $request)
    {
        if ($request->wantsJson()) {
            $limit = $request->rankingLimit();
            $ranking = SongRequest::betweenDates($request->from, $request->to)->getRankingBy('song.artist_id', $limit);
            return view('pages.statistics.artists.table', compact('ranking', 'limit'))->render();
        }

        return view('pages.statistics.artists.index');
    }

    public function genres(StatisticsRequest $request)
    {
        if ($request->wantsJson()) {
            $limit = $request->rankingLimit();
            $ranking = SongRequest::betweenDates($request->from, $request->to)->getRankingBy('song.genre_id', $limit);
            return view('pages.statistics.genres.table', compact('ranking', 'limit'))->render();
        }

        return view('pages.statistics.genres.index');
    }

    public function users(StatisticsRequest $request)
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
                    $limit = $request->rankingLimit();
                    $ranking = SongRequest::betweenDates($request->from, $request->to)->getRankingBy('user_id', $limit);
                    return view('pages.statistics.users.table', compact('ranking', 'limit'))->render();
                    break;
            }
        }
        
        return view('pages.statistics.users.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\WinnerAnnounced;
use App\Mail\Users\WinnerEmail;

class WinnersController extends Controller
{
    public function broadcast()
    {
        try {
            WinnerAnnounced::dispatch(auth()->user()->liveGig());
        } catch (\Exception $e) {
            return back()->with('error', 'O vencedor não pode ser anunciado');
        }

        return back()->with('success', 'Um email foi enviado para o vencedor');
    }

    public function show()
    {
        $gig = auth()->user()->liveGig();
        $ratings = $gig->ratings->reverse()->groupBy('song_request_id');
        $votersCount = $gig->ratings->groupBy('user_id')->count();
        $ranking = $gig->ranking();

        if ($ranking->ratings->isEmpty())
            return back()->with('error', 'Esse evento ainda não tem nenhum voto');

        $winner = $ranking->ratings->first();

        if (! $gig->winner()->exists())
            \Mail::to($winner->songRequest->user->email)->queue(new WinnerEmail($ranking));

        $gig->winner()->associate($winner->songRequest)->save();

        return view('pages.ratings.winner.index', compact(['ranking', 'winner', 'ratings', 'votersCount']));
    }
}

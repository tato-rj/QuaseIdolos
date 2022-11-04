<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, SongRequest};
use App\Events\{SongRequested, SongCancelled};
use App\Http\Requests\SongRequestForm;

class SongRequestsController extends Controller
{
    public function store(Request $request, Song $song, SongRequestForm $form)
    {
        SongRequested::dispatch(
            (new SongRequest)->add(auth()->user(), $song, liveGig())
        );

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin()) {
            $songRequest = SongRequest::waiting()->first();

            if ($songRequest)
                return view('pages.song-requests.alerts.admin', compact('songRequest'))->render();
        } else {
            $gig = liveGig();

            $songRequest = $gig ? auth()->user()->songRequests()->forGig($gig)->waiting()->first() : null;

            if ($songRequest)
                return view('pages.song-requests.alerts.user', compact('songRequest'))->render();
        }
    }

    public function alertAdmin(Request $request)
    {
        return view('pages.song-requests.alerts.admin')->render();
    }

    public function finish(SongRequest $songRequest)
    {
        $songRequest->finish();

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel(SongRequest $songRequest)
    {
        $this->authorize('update', $songRequest);

        if ($songRequest->isOver())
            return back();

        SongCancelled::dispatch($songRequest);
        
        $songRequest->delete();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

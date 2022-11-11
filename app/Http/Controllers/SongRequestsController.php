<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, SongRequest};
use App\Events\{SongRequested, SongFinished, SongCancelled};
use App\Http\Requests\SongRequestForm;

class SongRequestsController extends Controller
{
    public function store(Request $request, Song $song, SongRequestForm $form)
    {
        $songRequest = (new SongRequest)->add(auth()->user(), $song, auth()->user()->liveGig());

        try {
            SongRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            //
        }

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin()) {
            $songRequest = SongRequest::waiting()->first();

            if ($songRequest)
                return view('pages.song-requests.alerts.admin', compact('songRequest'))->render();
        } else {
            $songRequest = auth()->user()->songRequests()->forGig(auth()->user()->liveGig())->waiting()->first();

            if ($songRequest)
                return view('pages.song-requests.alerts.user', compact('songRequest'))->render();
        }
    }

    public function finish(SongRequest $songRequest)
    {
        $songRequest->finish();

        try {
            SongFinished::dispatch($songRequest);
        } catch (\Exception $e) {
            //
        }

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel($id)
    {
        $songRequest = SongRequest::find($id);

        if (! $songRequest || $songRequest->isOver())
            return back();

        $this->authorize('update', $songRequest);

        try {
            SongCancelled::dispatch($songRequest);
        } catch (\Exception $e) {
            //
        }
        
        $songRequest->delete();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

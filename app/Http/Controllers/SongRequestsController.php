<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, SongRequest};
use App\Events\{SongRequested, SongFinished, SongCancelled};
use App\Http\Requests\{SongRequestForm, ChangeSongRequestForm};

class SongRequestsController extends Controller
{
    public function store(Request $request, Song $song, SongRequestForm $form)
    {
        $songRequest = (new SongRequest)->add(auth()->user(), $song, auth()->user()->liveGig);

        try {
            SongRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            //
        }

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function update(Request $request, SongRequest $songRequest, ChangeSongRequestForm $form)
    {
        $request->validate(['new_song_id' => 'required|exists:songs,id']);

        $songRequest->update(['song_id' => $request->new_song_id]);

        try {
            SongRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            //
        }
        
        return back()->with('success', 'O seu pedido foi modificado com sucesso');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin())
            return;

        $songRequests = auth()->user()->songRequests()->forGig(auth()->user()->liveGig)->waiting()->get();

        if (! $songRequests->isEmpty())
            return view('pages.setlists.user.banner.index', compact('songRequests'))->render();
    }

    public function finish(SongRequest $songRequest)
    {
        $songRequest->finish();
        $songRequest->gig->sortSetlist();

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
        $songRequest->gig->sortSetlist();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

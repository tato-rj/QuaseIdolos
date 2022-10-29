<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, SongRequest, Gig};
use App\Events\{SongRequested, SongCancelled};

class SongRequestsController extends Controller
{
    public function user()
    {
        $pastList = auth()->user()->requestsSung();
        $waitingList = auth()->user()->requestsWaiting();

        return view('pages.song-requests.user.index', compact(['pastList', 'waitingList']));    
    }

    public function store(Request $request, Song $song)
    {
        $gig = gig();

        if (! $gig || $gig->is_paused)
            return back()->with('error', 'Não estamos recebendo pedidos agora');

        if ($gig->isFull())
            return back()->with('error', 'O limite do setlist de '.$gig->songs_limit.' músicas foi alcançado');

        if ($gig->canTakeRequestsFromUser())
            return back()->with('error', 'O seu limite de '.$gig->songs_limit_per_user.' músicas foi alcançado');

        $songRequest = (new SongRequest)->add(auth()->user(), $song, Gig::live()->first());

        SongRequested::dispatch($songRequest);

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin()) {
            $songRequest = SongRequest::waiting()->first();

            if ($songRequest)
                return view('pages.song-requests.alerts.admin', compact('songRequest'))->render();
        } else {
            $songRequest = auth()->user()->songRequests()->waiting()->first();

            if ($songRequest)
                return view('pages.song-requests.alerts.user', compact('songRequest'))->render();
        }
    }

    public function alertAdmin(Request $request)
    {
        return view('pages.song-requests.alerts.admin')->render();
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                SongRequest::find($set->id)->update(['order' => $set->order]);
            }
        }

        $setlist = SongRequest::waiting()->get();

        return view('pages.song-requests.components.table', compact('setlist'))->render();
    }

    public function finish(SongRequest $songRequest)
    {
        $songRequest->finish();

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel(SongRequest $songRequest)
    {
        if ($songRequest->isOver())
            return back();

        SongCancelled::dispatch($songRequest);
        
        $songRequest->delete();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

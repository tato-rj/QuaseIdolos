<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, Setlist};
use App\Events\{SongRequested, SongCancelled};

class SetlistController extends Controller
{
    public function user()
    {
        $pastList = auth()->user()->alreadySung();
        $waitingList = auth()->user()->waitingFor();

        return view('pages.setlist.user.index', compact(['pastList', 'waitingList']));    
    }

    public function store(Request $request, Song $song)
    {
        $setlist = (new Setlist)->add(auth()->user(), $song);

        SongRequested::dispatch($setlist);

        return redirect(route('setlist.user'))->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin()) {
            $setlist = Setlist::waiting()->first();

            if ($setlist)
                return view('pages.setlist.alerts.admin', compact('setlist'))->render();
        } else {
            $setlist = auth()->user()->setlists()->waiting()->first();

            if ($setlist)
                return view('pages.setlist.alerts.user', compact('setlist'))->render();
        }
    }

    public function alertAdmin(Request $request)
    {
        return view('pages.setlist.alerts.admin')->render();
    }

    public function table(Request $request)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                Setlist::find($set->id)->update(['order' => $set->order]);
            }
        }

        $setlist = Setlist::waiting()->get();

        return view('pages.setlist.components.table', compact('setlist'))->render();
    }

    public function live()
    {
        $setlist = Setlist::waiting()->get();

        return view('pages.setlist.live', compact('setlist'));
    }

    public function finish(Setlist $setlist)
    {
        $setlist->finish();

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel(Setlist $setlist)
    {
        if ($setlist->isOver())
            return back();

        SongCancelled::dispatch($setlist);
        
        $setlist->delete();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

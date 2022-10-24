<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Song, Setlist};

class SetlistController extends Controller
{
    public function store(Request $request, Song $song)
    {
        (new Setlist)->add(auth()->user(), $song);

        return back()->with('success', 'O seu nome está na lista, vai se preparando!');
    }

    public function alert()
    {
        if (auth()->user()->isAdmin()) {
            $request = Setlist::waiting()->first();

            if ($request)
                return view('pages.setlist.alerts.admin', compact('request'))->render();
        } else {
            $request = auth()->user()->setlist()->waiting()->first();

            if ($request)
                return view('pages.setlist.alerts.user', compact('request'))->render();
        }
    }

    public function live()
    {
        $setlist = Setlist::waiting()->get();

        return view('pages.setlist.live', compact('setlist'));
    }

    public function finish(Setlist $request)
    {
        $request->finish();

        return back()->with('success', 'O pedido foi completado com sucesso');
    }

    public function cancel(Setlist $request)
    {
        $request->delete();

        return back()->with('success', 'O pedido foi cancelado com sucesso');
    }
}

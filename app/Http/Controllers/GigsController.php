<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Http\Request;
use App\Events\GigFinished;

class GigsController extends Controller
{
    public function index()
    {
        $readyGigs = Gig::ready()->get();

        $otherGigs = Gig::except($readyGigs->pluck('id'))->byEventDate()->paginate(8);

        return view('pages.gigs.index', compact(['readyGigs', 'otherGigs']));
    }

    public function select(Request $request)
    {
        session(['origin' => $request->origin]);

        $gigs = Gig::ready()->get();

        $gigs = $gigs->sortBy(function($gig, $index) {
            return auth()->user()->distanceTo($gig);
        });

        return view('pages.gigs.join.index', compact('gigs'));
    }

    public function join(Request $request, Gig $gig)
    {
        if (! $gig->isLive())
            return back()->with('error', 'Esse evento não está aberto');

        if ($gig->isPaused())
            return back()->with('error', 'Esse evento volta daqui a pouco');


        auth()->user()->join($gig);

        $redirect = session()->has('origin') ? redirect(session('origin')) : back();
        
        return $redirect->with('modal', 'pages.gigs.join.modal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'song_limit' => 'integer',
            'song_limit_per_user' => 'integer',
        ]);

        Gig::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'lat' => $request->latitude,
            'lon' => $request->longitude,
            'repeat_limit' => $request->repeat_limit,
            'songs_limit' => $request->songs_limit,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for),
        ]);

        return back()->with('success', 'O evento foi criado com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function edit(Gig $gig)
    {
        return view('pages.gigs.edit', compact('gig'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gig $gig)
    {
        $request->validate([
            'name' => 'required',
            'repeat_limit' => 'integer',
            'song_limit' => 'integer',
            'song_limit_per_user' => 'integer',
        ]);

        $gig->update([
            'name' => $request->name,
            'description' => $request->description,
            'repeat_limit' => $request->repeat_limit,
            'lat' => $request->latitude,
            'lon' => $request->longitude,
            'songs_limit' => $request->songs_limit,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for) ?? $gig->scheduled_for,
        ]);

        return back()->with('success', 'O evento foi alterado com sucesso');
    }

    public function duplicate(Request $request, Gig $gig)
    {
        $gig->duplicate();

        return back()->with('success', 'O evento foi duplicado com sucesso');
    }

    public function pause(Request $request, Gig $gig)
    {
        $gig->update(['is_paused' => ! $gig->is_paused]);

        $message = $gig->is_paused ? 'O evento está pausado' : 'O evento voltou';

        return view('components.core.alerts.regular', [
            'message' => $message,
            'icon' => ! $gig->is_paused ? 'play' : 'pause', 
            'color' => ! $gig->is_paused ? 'green' : 'yellow', 
            'pos' => 'top', 
            'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown'], 
            'countdown' => 3
        ])->render();
    }

    public function open(Request $request, Gig $gig)
    {
        $gig->update([
            'is_live' => true,
            'starts_at' => now(),
        ]);

        return back()->with('success', 'O evento começou');
    }

    public function close(Request $request, Gig $gig)
    {
        GigFinished::dispatch($gig);

        $gig->update([
            'is_live' => false,
            'ends_at' => now()
        ]);

        $gig->participants()->detach();

        return back()->with('success', 'O evento terminou');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gig $gig)
    {
        if ($gig->setlist()->waiting()->exists())
            return back()->with('error', 'O setlist ainda tem pedidos na espera');

        $gig->participants()->detach();
        $gig->delete();

        return redirect(route('gig.index'))->with('success', 'O evento foi removido com sucesso');
    }
}

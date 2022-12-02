<?php

namespace App\Http\Controllers;

use App\Models\{Gig, Venue};
use Illuminate\Http\Request;
use App\Events\GigFinished;

class GigsController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        $today = Gig::ready()->get();
        $unscheduled = Gig::unscheduled()->get();

        return view('pages.gigs.index', compact(['today', 'venues', 'unscheduled']));
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
            'venue_id' => 'required|exists:venues,id',
            'song_limit' => 'integer',
            'song_limit_per_user' => 'integer',
            'scheduled_for' => 'required',
        ]);

        Gig::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'venue_id' => $request->venue_id,
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
        if (! $gig->hasDate())
            return redirect(route('gig.index'));

        $venues = Venue::all();

        return view('pages.gigs.edit', compact(['gig', 'venues']));
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
            'venue_id' => 'required|exists:venues,id',
            'song_limit' => 'integer',
            'song_limit_per_user' => 'integer',
        ]);

        $gig->update([
            'name' => $request->name,
            'description' => $request->description,
            'venue_id' => $request->venue_id,
            'repeat_limit' => $request->repeat_limit,
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
        $this->authorize('open', $gig);
        
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
            'is_paused' => false,
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

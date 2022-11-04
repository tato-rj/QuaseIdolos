<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Http\Request;

class GigsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $readyGigs = Gig::ready()->get();
        // return $readyGigs;
        $otherGigs = Gig::except($readyGigs->pluck('id'))->byEventDate()->paginate(8);

        return view('pages.gigs.index', compact(['readyGigs', 'otherGigs']));
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
            'songs_limit' => $request->songs_limit,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'date' => datePtToUs($request->date),
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
            'song_limit' => 'integer',
            'song_limit_per_user' => 'integer',
        ]);

        $gig->update([
            'name' => $request->name,
            'description' => $request->description,
            'songs_limit' => $request->songs_limit,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'date' => datePtToUs($request->date) ?? $gig->date,
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
            'countdown' => 3000000000
        ])->render();
    }

    public function status(Request $request, Gig $gig)
    {
        $liveGig = liveGig();

        if ($liveGig && ! $gig->is($liveGig)) {
            return view('components.core.alerts.regular', [
                'message' => 'Já existe um evento acontecendo',
                'icon' => 'hand-paper', 
                'color' => 'red', 
                'pos' => 'top', 
                'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown'], 
                'countdown' => 3
            ])->render();
        }

        $gig->update([
            'is_live' => ! $gig->is_live,
            'starts_at' => $gig->starts_at ?? now(),
            'ends_at' => $gig->is_live ? now() : null,
            'is_paused' => $gig->is_live ? false : $gig->is_paused
        ]);

        $message = $gig->is_live ? 'O evento começou' : 'O evento acabou';

        return view('components.core.alerts.regular', [
            'message' => $message,
            'icon' => $gig->is_live ? 'thumbs-up' : 'hand-paper', 
            'color' => $gig->is_live ? 'green' : 'yellow', 
            'pos' => 'top', 
            'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown'], 
            'countdown' => 3
        ])->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gig $gig)
    {
        $gig->setlist()->waiting()->get()->each->delete();
        $gig->delete();

        return redirect(route('gig.index'))->with('success', 'O evento foi removido com sucesso');
    }
}

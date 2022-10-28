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
        $otherGigs = Gig::except($readyGigs->pluck('id'))->byEventDate()->paginate(8);

        return view('pages.gigs.index', compact(['readyGigs', 'otherGigs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'date' => 'required'
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
     * Display the specified resource.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function show(Gig $gig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function edit(Gig $gig)
    {
        //
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
        //
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

    public function status(Request $request, Gig $gig)
    {
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
        //
    }
}

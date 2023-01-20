<?php

namespace App\Http\Controllers;

use App\Models\{Gig, Venue, Participant, Admin};
use Illuminate\Http\Request;
use App\Events\GigFinished;

class GigsController extends Controller
{
    public function index()
    {
        $musicians = Admin::musicians()->get();
        $venues = Venue::all();
        $today = Gig::ready()->orLive()->get();
        $unscheduled = Gig::unscheduled()->get();

        return view('pages.gigs.index', compact(['today', 'venues', 'unscheduled', 'musicians']));
    }

    public function password(Gig $gig)
    {
        if (! $gig->password()->required())
            return back()->with('error', 'Esse evento não precisa de senha');

        return view('pages.gigs.show.password', compact('gig'));
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

        $this->authorize('join', $gig);

        auth()->user()->join($gig);

        $redirect = session()->has('origin') ? redirect(session('origin')) : back();
        
        return $redirect->with('modal', 'pages.gigs.welcome.modal');
    }

    public function verifyPassword(Request $request, Gig $gig)
    {
        return $gig->password()->verify($request->password) ? response(200) : response('A senha está incorreta', 401);
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

        $gig = Gig::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'repeat_limit' => $request->repeat_limit,
            'songs_limit' => $request->songs_limit,
            'is_private' => $request->is_private ? 1 : 0,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for),
        ]);

        $gig->musicians()->attach($request->musicians);

        if ($request->has_password) {
            $gig->password()->update();
        }

        return back()->with('success', 'O evento foi criado com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gig  $gig
     * @return \Illuminate\Http\Response
     */
    public function show(Gig $gig)
    {
        if ($gig->isUnscheduled())
            return redirect(route('gig.index'));

        $musicians = Admin::musicians()->get();
        $venues = Venue::all();

        return view('pages.gigs.show.index', compact(['gig', 'venues', 'musicians']));
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
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'repeat_limit' => $request->repeat_limit,
            'songs_limit' => $request->songs_limit,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'is_private' => $request->is_private ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for) ?? $gig->scheduled_for,
        ]);

        $gig->musicians()->sync($request->musicians);

        if ($request->has_password) {
            if (! $gig->password()->required())
                $gig->password()->update();
        } else {
            $gig->password()->destroy();
        }

        return back()->with('success', 'O evento foi alterado com sucesso');
    }

    public function updatePassword(Request $request, Gig $gig)
    {
        $gig->password()->update();

        return back()->with('success', 'A senha foi alterada com sucesso');
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

        return back()->with('success', $message);

        // return view('components.core.alerts.regular', [
        //     'message' => $message,
        //     'icon' => ! $gig->is_paused ? 'play' : 'pause', 
        //     'color' => ! $gig->is_paused ? 'green' : 'yellow', 
        //     'pos' => 'top', 
        //     'animation' => ['in' => 'fadeInUp', 'out' => 'fadeOutDown'], 
        //     'countdown' => 3
        // ])->render();
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

        $gig->setlist()->waiting()->delete();
        Participant::in($gig)->unconfirmed()->confirm();

        $gig->archives()->save();

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
        $gig->musicians()->detach();
        $gig->delete();

        if (url()->previous() == route('gig.show', $gig))
            return redirect(route('gig.index'))->with('success', 'O evento foi removido com sucesso');

        return back()->with('success', 'O evento foi removido com sucesso');
    }
}

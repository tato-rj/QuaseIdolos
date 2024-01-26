<?php

namespace App\Http\Controllers;

use App\Models\{Gig, Venue, Participant, Admin, Show, Song, Set};
use Illuminate\Http\Request;
use App\Events\GigFinished;

class GigsController extends Controller
{
    public function index()
    {
        $musicians = Admin::musicians()->get();
        $venues = Venue::all();
        $kareokeToday = Gig::ready()->orLive()->get();
        $unscheduled = Gig::unscheduled()->get();
        $kareokes = Gig::withCount(['participants', 'setlist'])->notReady()->sortable('scheduled_for')->paginate(8);

        return view('pages.gigs.index', compact(['kareokes', 'kareokeToday', 'venues', 'unscheduled', 'musicians']));
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

        $gigs->each(function($gig) {
            $gig->joined = auth()->user()->joined($gig) ? 1 : 0;
        });

        if ($gigs->where('joined', true)->isEmpty()) {
            $gigs = $gigs->sortBy(function($gig, $index) {
                return auth()->user()->distanceTo($gig);
            });
        } else {
            $gigs = $gigs->sortByDesc('joined');
        }
        
        $gigs = $gigs->values();
        
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

    public function leave(Request $request, Gig $gig)
    {
        auth()->user()->leave($gig);
        
        return back()->with('success', 'Você não está mais participando desse evento');
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
            'set_limit' => 'nullable|integer',
            'song_limit' => 'nullable|integer',
            'song_limit_per_user' => 'nullable|integer',
            'scheduled_for' => 'required',
            'password' => 'sometimes|nullable|digits:4|numeric'
        ]);

        $gig = Gig::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'repeat_limit' => $request->repeat_limit,
            'songs_limit' => $request->songs_limit,
            'set_limit' => $request->set_limit,
            'duration' => $request->duration,
            'is_private' => $request->is_private ? 1 : 0,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'participates_in_chat' => $request->participates_in_chat ? 1 : 0,
            'is_test' => $request->is_test ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for),
        ]);

        $gig->musicians()->attach($request->musicians);

        if ($request->has_password)
            $gig->password()->update($request->password);

        return back()->with('success', 'O karaokê foi criado com sucesso');
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
            'set_limit' => 'nullable|integer',
            'song_limit' => 'nullable|integer',
            'song_limit_per_user' => 'nullable|integer',
            'password' => 'sometimes|nullable|digits:4|numeric'
        ]);

        $gig->update([
            'name' => $request->name,
            'description' => $request->description,
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'repeat_limit' => $request->repeat_limit,
            'songs_limit' => $request->songs_limit,
            'set_limit' => $request->set_limit,
            'duration' => $request->duration,
            'has_ratings' => $request->has_ratings ? 1 : 0,
            'is_private' => $request->is_private ? 1 : 0,
            'participates_in_chat' => $request->participates_in_chat ? 1 : 0,
            'is_test' => $request->is_test ? 1 : 0,
            'songs_limit_per_user' => $request->songs_limit_per_user,
            'scheduled_for' => datePtToUs($request->scheduled_for) ?? $gig->scheduled_for,
        ]);

        $gig->musicians()->sync($request->musicians);

        if ($request->has_password) {
            $gig->password()->update($request->password);
        } else {
            $gig->password()->destroy();
        }

        if (is_null($request->set_limit)) {
            $gig->sets()->delete();
        } else {
            if (! $gig->sets()->current()->exists()) {
                Set::new($gig);
            } elseif ($request->change_set_limit_now) {
                $gig->sets()->current()->update([
                    'limit' => $request->set_limit,
                    'songs_left' => $request->set_limit - $gig->setlist()->waiting()->count()
                ]);
            }
        }

        return back()->with('success', 'O karaokê foi alterado com sucesso');
    }

    public function updatePassword(Request $request, Gig $gig)
    {
        $gig->password()->update();

        return back()->with('success', 'A senha foi alterada com sucesso');
    }

    public function duplicate(Request $request, Gig $gig)
    {
        $gig->duplicate();

        return back()->with('success', 'O karaokê foi duplicado com sucesso');
    }

    public function pause(Request $request, Gig $gig)
    {
        $gig->update(['is_paused' => ! $gig->is_paused]);

        $message = $gig->is_paused ? 'O karaokê está pausado' : 'O karaokê voltou';

        return back()->with('success', $message);
    }

    public function open(Request $request, Gig $gig)
    {
        $this->authorize('open', $gig);
        
        $gig->open();

        if (! $gig->sets()->exists() && $gig->set_limit)
            Set::new($gig);

        return back()->with('success', 'O karaokê começou');
    }

    public function close(Request $request, Gig $gig)
    {
        GigFinished::dispatch($gig);

        $gig->close();

        if ($gig->sets()->exists())
            $gig->sets()->delete();

        return back()->with('success', 'O karaokê terminou');
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

        $gig->participants()->delete();
        $gig->chats()->delete();
        $gig->musicians()->detach();
        $gig->delete();

        if (url()->previous() == route('gig.show', $gig))
            return redirect(route('gig.index'))->with('success', 'O karaokê foi removido com sucesso');

        return back()->with('success', 'O karaokê foi removido com sucesso');
    }
}

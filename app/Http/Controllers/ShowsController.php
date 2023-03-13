<?php

namespace App\Http\Controllers;

use App\Models\{Show, Admin, Venue, Song, Setlist};
use Illuminate\Http\Request;

class ShowsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return back()->with('error', 'Não está pronto ainda');

        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'scheduled_for' => 'required'
        ]);

        $show = Show::create([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'duration' => $request->duration,
            'scheduled_for' => datePtToUs($request->scheduled_for),
        ]);

        $show->musicians()->attach($request->musicians);

        return back()->with('success', 'O show foi criado com sucesso');
    }

    public function open(Request $request, Show $show)
    {
        // $this->authorize('open', $show);
        
        $show->open();

        return back()->with('success', 'O show começou');
    }


    public function close(Request $request, Show $show)
    {
        $show->close();

        return back()->with('success', 'O karaokê terminou');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function edit(Show $show)
    {
        if ($show->isUnscheduled())
            return redirect(route('shows.index'));

        $musicians = Admin::musicians()->get();
        $venues = Venue::all();

        return view('pages.shows.edit.index', compact(['show', 'venues', 'musicians']));
    }

    public function search(Request $request, Show $show)
    {
        if (strlen($request->input) <= 3) {
            $songs = collect();
        } else {
            $songs = Song::search($request->input)->orderBy('name')->get();
        }

        return view('pages.shows.edit.results', compact(['songs', 'show']))->render();
    }

    public function updateSetlist(Show $show, Song $song)
    {
        (new Setlist)->toggle($show, $song);

        $show->setlist()->reorder();

        return view('pages.shows.edit.setlist', compact('show'))->render();
    }

    public function setlist(Request $request, Show $show)
    {
        if ($request->has('newOrder')) {
            foreach($request->newOrder as $data) {
                $set = json_decode($data);
                if ($setlist = Setlist::find($set->id))
                    $setlist->update(['order' => $set->order]);
            }
        }

        return view('pages.shows.edit.setlist', compact('show'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Show $show)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'scheduled_for' => 'required'
        ]);

        $show->update([
            'creator_id' => auth()->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_time' => $request->starting_time,
            'venue_id' => $request->venue_id,
            'duration' => $request->duration,
            'scheduled_for' => datePtToUs($request->scheduled_for) ?? $show->scheduled_for,
        ]);

        $show->musicians()->sync($request->musicians);

        return back()->with('success', 'O show foi alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function destroy(Show $show)
    {
        $show->musicians()->detach();
        $show->setlist()->delete();
        $show->delete();

        if (url()->previous() == route('shows.edit', $show))
            return redirect(route('gig.index'))->with('success', 'O show foi removido com sucesso');

        return back()->with('success', 'O show foi removido com sucesso');
    }
}

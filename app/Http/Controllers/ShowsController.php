<?php

namespace App\Http\Controllers;

use App\Models\{Show, Admin, Venue, Song, Setlist};
use Illuminate\Http\Request;

class ShowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function show(Show $show)
    {
        if ($show->isUnscheduled())
            return redirect(route('shows.index'));

        $musicians = Admin::musicians()->get();
        $venues = Venue::all();

        return view('pages.shows.show.index', compact(['show', 'venues', 'musicians']));
    }

    public function search(Request $request, Show $show)
    {
        if (strlen($request->input) <= 3) {
            $songs = collect();
        } else {
            $songs = Song::search($request->input)->orderBy('name')->get();
        }

        return view('pages.shows.show.results', compact(['songs', 'show']))->render();
    }

    public function updateSetlist(Show $show, Song $song)
    {
        (new Setlist)->toggle($show, $song);

        $show->setlist()->reorder();

        return view('pages.shows.show.setlist', compact('show'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function edit(Show $show)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show  $show
     * @return \Illuminate\Http\Response
     */
    public function destroy(Show $show)
    {
        //
    }
}

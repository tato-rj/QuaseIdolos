<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Venue, Admin};

class VenuesController extends Controller
{
    public function index()
    {
        $venues = Venue::all();

        return view('pages.venues.index', compact('venues'));
    }

    public function today(Venue $venue)
    {
        $table = view('pages.venues.show.tables.today', compact('venue'));

        return view('pages.venues.show.index', compact(['table', 'venue']));
    }

    public function past(Venue $venue)
    {
        $table = view('pages.venues.show.tables.past', compact('venue'));

        return view('pages.venues.show.index', compact(['table', 'venue']));
    }

    public function upcoming(Venue $venue)
    {
        $table = view('pages.venues.show.tables.upcoming', compact(['venue']));

        return view('pages.venues.show.index', compact(['table', 'venue']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:venues,name',
            'uid' => 'required|unique:venues,uid',
        ]);

        Venue::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'description' => $request->description,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);

        return back()->with('success', 'O contratante foi criado com sucesso');
    }

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required',
            'uid' => 'required'
        ]);

        $venue->update([
            'uid' => $request->uid,
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'description' => $request->description,
            'lat' => $request->lat,
            'lon' => $request->lon,
        ]);

        return back()->with('success', 'O contratante foi editado com sucesso');
    }

    public function destroy(Venue $venue)
    {
        $venue->gigs->each->delete();

        $venue->delete();

        return back()->with('success', 'O contratante foi removido com sucesso');
    }
}

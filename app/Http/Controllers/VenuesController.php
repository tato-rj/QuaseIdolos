<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

class VenuesController extends Controller
{
    public function index()
    {
        $venues = Venue::all();

        return view('pages.venues.index', compact('venues'));
    }

    public function show(Venue $venue)
    {
        return view('pages.venues.show.index', compact('venue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:venues,name'
        ]);

        Venue::create([
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
            'name' => 'required'
        ]);

        $venue->update([
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

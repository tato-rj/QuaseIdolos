<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::orderBy('name')->get();

        return view('pages.songs.index', compact('songs'));
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
            'name' => 'required|string',
            'lyrics' => 'required',
            'duration' => 'required',
            'artist_id' => 'required'
        ]);

        Song::create([
            'artist_id' => $request->artist_id,
            'name' => $request->name,
            'tags' => preg_replace('/\s+/', ' ', $request->tags),
            'duration' => $request->duration,
            'level' => $request->level,
            'lyrics' => $request->lyrics
        ]);

        return back()->with('success', 'A música foi adicionada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'name' => 'required|string',
            'duration' => 'required',
            'lyrics' => 'required'
        ]);

        $song->update([
            'name' => $request->name,
            'tags' => preg_replace('/\s+/', ' ', $request->tags),
            'duration' => $request->duration,
            'level' => $request->level,
            'lyrics' => $request->lyrics
        ]);

        return back()->with('success', 'A música foi atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return back()->with('success', 'A música foi removida com sucesso');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\{Song, Genre};
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
        $songs = Song::sortable('name', 'ASC')->paginate(12);
        $genres = Genre::orderBy('name')->get();

        return view('pages.songs.index', compact(['songs', 'genres']));
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
            'genre_id' => 'required',
            'artist_id' => 'required'
        ]);

        $song = Song::create([
            'artist_id' => $request->artist_id,
            'genre_id' => $request->genre_id,
            'name' => $request->name,
            'duration' => $request->duration,
            'lyrics' => $request->lyrics,
            'chords_url' => $request->chords_url
        ]);

        $song->getMusicData();

        return back()->with('success', 'A música foi adicionada com sucesso');
    }

    public function search(Request $request)
    {
        $songs = Song::search($request->input)->orderBy('name')->paginate(12);
        $genres = Genre::orderBy('name')->get();

        return view('pages.songs.results', compact(['songs', 'genres']))->render();
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
            'genre_id' => 'required',
            'lyrics' => 'required'
        ]);

        $song->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'genre_id' => $request->genre_id,
            'lyrics' => $request->lyrics,
            'chords_url' => $request->chords_url,
            'bpm' => $request->bpm,
            'preview_url' => $request->preview_url
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
        $song->songRequests->each->delete();
        $song->delete();

        return back()->with('success', 'A música foi removida com sucesso');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MetronomeRequested;
use App\Models\Song;

class MetronomeController extends Controller
{
    public function update(Request $request, Song $song)
    {
        $song->update(['bpm' => $request->tempo]);

        return response(200);
    }

    public function index()
    {
        return view('pages.songs.metronome.index');
    }

    public function show(Song $song)
    {
        return view('pages.songs.metronome.show', compact('song'))->render();
        
    }
}

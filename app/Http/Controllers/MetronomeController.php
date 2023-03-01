<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MetronomeRequested;
use App\Models\{Song, SongRequest};

class MetronomeController extends Controller
{
    public function get(SongRequest $songRequest)
    {
        try {
            MetronomeRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            bugreport($e);
            abort(503);
        }
        
        return response(200);
    }

    public function update(Request $request)
    {
        // $songRequest = SongRequest::findOrFail($request->id);

        // $songRequest->song->update(['bpm' => $request->tempo]);

        return $request->all();//response(200);
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

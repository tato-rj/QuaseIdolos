<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\LyricsRequested;
use App\Models\{SongRequest, Gig, Song};

class LyricsController extends Controller
{
    public function get(SongRequest $songRequest)
    {
        try {
            LyricsRequested::dispatch($songRequest);
        } catch (\Exception $e) {
            abort(503);
        }
        
        return response(200);
    }

    public function search(Request $request)
    {
        $input = preg_replace("/(.)\\1+/", "$1", $request->input);
        
        $songs = Song::search($input)->get();

        return view('pages.songs.lyrics.table', compact('songs'))->render();
    }

    public function index()
    {
        return view('pages.songs.lyrics.index');
    }
}

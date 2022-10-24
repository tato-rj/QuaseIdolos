<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Song};

class CardapioController extends Controller
{
    public function index()
    {
        $artists = Artist::orderby('name')->get();

        return view('pages.cardapio.index', compact('artists'));    
    }

    public function byArtist(Artist $artist)
    {
        $songs = $artist->songs;

        return view('pages.cardapio.results.table', compact('songs'))->render();
    }

    public function search(Request $request)
    {
        $input = preg_replace("/(.)\\1+/", "$1", $request->input);
        
        $songs = Song::search($input)->get();

        return view('pages.cardapio.results.table', compact('songs'))->render();
    }
}

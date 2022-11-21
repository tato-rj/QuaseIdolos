<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Song, Genre};

class CardapioController extends Controller
{
    public function index()
    {
        $artists = Artist::orderby('name')->paginate(4);
        $genres = Genre::orderby('name')->get();

        $songs = request()->has('input') ? Song::search(request()->input)->get() : collect();

        return view('pages.cardapio.index', compact(['artists', 'songs', 'genres']));    
    }

    public function artist(Artist $artist)
    {
        return view('pages.cardapio.artist', compact('artist'));
    }

    public function search(Request $request)
    {
        $input = preg_replace("/(.)\\1+/", "$1", $request->input);
        
        $songs = Song::search($input)->get();

        return view('pages.cardapio.results.table', compact('songs'))->render();
    }
}

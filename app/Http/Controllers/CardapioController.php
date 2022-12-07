<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Song, Genre, Gig};

class CardapioController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && ! auth()->user()->liveGig()) {
            if (auth()->user()->tryToJoin(Gig::ready()))
                session()->flash('modal', 'pages.gigs.join.modal');
        }
        
        if (Artist::bySlug($request->artista)->exists()) {
            $songs = Artist::bySlug($request->artista)->first()->songs()->alphabetically()->paginate(4);
        } else {
            $songs = $request->has('input') ? Song::search($request->input)->alphabetically()->paginate(12) : collect();
        }
        
        $artists = Artist::orderby('name')->has('songs')->paginate(24);
        $genres = Genre::orderby('name')->has('songs')->get();

        return view('pages.cardapio.index', compact(['artists', 'songs', 'genres']));
    }

    public function artist(Artist $artist)
    {
        return view('pages.cardapio.artist', compact('artist'));
    }

    public function search(Request $request)
    {
        if (auth()->check())
            auth()->user()->tryToJoin(Gig::ready());
        
        $songs = Song::search($request->input)->alphabetically()->paginate(12);

        return view('pages.cardapio.results.table', compact('songs'))->render();
    }
}

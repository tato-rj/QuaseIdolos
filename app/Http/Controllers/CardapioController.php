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
                session()->flash('modal', 'pages.gigs.welcome.modal');
        }
        
        if ($request->has('input')) {
            $songs = Song::search($request->input)->alphabetically()->paginate(12);
        } else {
            if (Artist::bySlug($request->artista)->exists()) {
                $songs = Artist::bySlug($request->artista)->first()->songs()->alphabetically()->paginate(12);
            } elseif (Genre::bySlug($request->estilo)->exists()) {
                $songs = Genre::bySlug($request->estilo)->first()->songs()->alphabetically()->paginate(12);
            } else {
                $songs = collect();
            }
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Artist, Song, Genre, Gig};

class CardapioController extends Controller
{
    protected $songsPerPage = 12;
    protected $artistsPerPage = 24;

    public function index(Request $request)
    {        
        if ($request->has('input')) {
            $songs = Song::search($request->input)->alphabetically()->paginate($this->songsPerPage);
        } else {
            if (Artist::bySlug($request->artista)->exists()) {
                $songs = Artist::bySlug($request->artista)->first()->songs()->alphabetically()->paginate($this->songsPerPage);
            } elseif (Genre::bySlug($request->estilo)->exists()) {
                $songs = Genre::bySlug($request->estilo)->first()->songs()->alphabetically()->paginate($this->songsPerPage);
            } else {
                $songs = collect();
            }
        }

        $artists = Artist::orderby('name')->has('songs')->paginate($this->artistsPerPage);
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
        
        $query = Song::search($request->input)->alphabetically();
        $songs = $request->paginate ? $query->paginate($this->songsPerPage) : $query->get();
        $table = $request->table ?? 'pages.cardapio.results.table';
        $songRequestId = $request->song_request_id;

        return view($table, compact(['songs', 'songRequestId']))->render();
    }
}

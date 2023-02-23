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
        if ($request->has('musica')) {
            $songs = Song::where('id', $request->musica)->visibleArtist()->paginate($this->songsPerPage);
        } elseif ($request->has('input')) {
            $songs = Song::search($request->input)->alphabetically()->paginate($this->songsPerPage);
        } else {
            if ($request->has('artista')) {
                $songs = Song::byArtist($request->artista)->alphabetically()->paginate($this->songsPerPage);
            } elseif ($request->has('estilo')) {
                $songs = Song::byGenre($request->estilo)->visibleArtist()->alphabetically()->paginate($this->songsPerPage);
            } else {
                $songs = collect();
            }
        }

        $artists = Artist::orderby('name')->visible()->has('songs')->paginate($this->artistsPerPage);
        $genres = Genre::orderby('name')->has('songs')->get();

        return view('pages.cardapio.index', compact(['artists', 'songs', 'genres']));
    }

    public function modal(Song $song)
    {
        $gigCount = Gig::ready()->count();

        if (auth()->check()) {
            if (auth()->user()->admin()->exists()) {
                $songRequests = auth()->user()->liveGigExists() ? auth()->user()->liveGig->setlist()->waiting()->with(['song', 'user'])->get() : collect();
            } else {
                $songRequests = auth()->user()->songRequests()->waiting()->with(['song', 'user'])->get();
            }
        } else {
            $songRequests = collect();
        }

        return view('pages.cardapio.components.song.content', compact(['song', 'gigCount', 'songRequests']))->render();
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

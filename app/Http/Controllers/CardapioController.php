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
        $request->validate([
            'input' => 'nullable|string|max:255',
            'artista' => 'nullable|string|max:255',
            'estilo' => 'nullable|string|max:255',
            'musica' => 'nullable|integer',
        ]);

        $songs = Song::cardapio($request)->forCardapioListing()->shouldShow()->visibleArtist()
            ->alphabetically()->paginate($this->songsPerPage)->withQueryString();

        $artists = Artist::orderby('name')->visible()->whereHas('songs', function($q) {
            $q->shouldShow();
        })->paginate($this->artistsPerPage)->withQueryString();
        
        $genres = cache()->remember('genres', now()->addDay(), function() {
            return Genre::orderby('name')->has('songs')->get();
        });

        return view('pages.cardapio.index', compact(['artists', 'songs', 'genres']));
    }

    public function modal($songId)
    {
        // Request counts and edited lyrics must reflect the current database state.
        $song = Song::findOrFail($songId);

        $gigCount = Gig::ready()->count();

        if (auth()->check()) {
            if (auth()->user()->admin) {
                if (auth()->user()->liveGigExists() && auth()->user()->liveGig->isKareoke()) {
                    $songRequests =  auth()->user()->liveGig->setlist()->waiting()->with(['song', 'user'])->get();
                } else {
                    $songRequests = collect();
                }
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
        $request->validate([
            'input' => 'nullable|string|max:255',
            'song_request_id' => 'nullable|integer',
            'table' => 'nullable|in:pages.cardapio.results.table,pages.song-requests.change.table',
        ]);

        if (auth()->check())
            auth()->user()->tryToJoin(Gig::ready()->get());
        
        $query = Song::search($request->input)->forCardapioListing()->shouldShow()->alphabetically();
        $songs = $request->boolean('paginate')
            ? $query->paginate($this->songsPerPage)->withQueryString() : $query->get();
        $table = $request->table ?? 'pages.cardapio.results.table';
        $songRequestId = $request->song_request_id;

        return view($table, compact(['songs', 'songRequestId']))->render();
    }
}

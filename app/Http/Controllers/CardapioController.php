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
        $songs = Song::cardapio($request)->visibleArtist()->alphabetically()->paginate($this->songsPerPage);
        $artists = Artist::orderby('name')->visible()->has('songs')->paginate($this->artistsPerPage);
        $genres = cache()->remember('genres', now()->addDay(), function() {
            return Genre::orderby('name')->has('songs')->get();
        });

        return view('pages.cardapio.index', compact(['artists', 'songs', 'genres']));
    }

    public function modal($songId)
    {
        $song = cache()->remember('song.'.$songId, now()->addDay(), function() use ($songId) {
            return Song::find($songId);
        });

        $gigCount = Gig::ready()->count();

        if (auth()->check()) {
            if (auth()->user()->admin()->exists()) {
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
        if (auth()->check())
            auth()->user()->tryToJoin(Gig::ready());
        
        $query = Song::search($request->input)->alphabetically();
        $songs = $request->paginate ? $query->paginate($this->songsPerPage) : $query->get();
        $table = $request->table ?? 'pages.cardapio.results.table';
        $songRequestId = $request->song_request_id;

        return view($table, compact(['songs', 'songRequestId']))->render();
    }
}

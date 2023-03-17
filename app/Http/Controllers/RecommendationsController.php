<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spotify as SpotifyApi;
use SpotifySeed;
use App\Tools\MusicData\MusicData;
use App\Models\Song;

class RecommendationsController extends Controller
{
    public function get()
    {
        // return SpotifyApi::track('2WjLc16JdLH2V6FMk8VFsZ')->get();
        // return SpotifyApi::searchTracks('João Penca & Seus Miquinhos Amestrados - popstar')->limit(5)->get();
        $songs = Song::inRandomOrder()->take(3)->get();   

        $seeder = SpotifySeed::addGenres($songs->pluck('genre.name'))
                             ->addTracks($songs->pluck('spotify_id'));

        $results = SpotifyApi::recommendations($seeder)->limit(10)->get();

        return randval($results['tracks']);
    }
}

https://open.spotify.com/track/2WjLc16JdLH2V6FMk8VFsZ?si=5f57556745b746be
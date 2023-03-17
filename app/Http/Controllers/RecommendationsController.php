<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spotify as SpotifyApi;
use SpotifySeed;
use App\Tools\MusicData\MusicData;

class RecommendationsController extends Controller
{
    public function get()
    {
        // return SpotifyApi::track('2WjLc16JdLH2V6FMk8VFsZ')->get();
        // return SpotifyApi::searchTracks('João Penca & Seus Miquinhos Amestrados - popstar')->limit(5)->get();

        $seeder = SpotifySeed::addArtists(['4NHQUGzhtTLFvgF5SZesLK'])->addGenres(['classical', 'country'])->addTracks(['0c6xIDDpzE81m2q797ordA']);

        return SpotifyApi::recommendations($seeder)->limit(10)->get();
    }
}

https://open.spotify.com/track/2WjLc16JdLH2V6FMk8VFsZ?si=5f57556745b746be
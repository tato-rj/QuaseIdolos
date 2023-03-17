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
        return (new MusicData)->artist('zeca pagodinho')->get()['artist_id'];

        $results = SpotifyApi::searchTracks('zeca pagodinho')->limit(5)->get()['tracks']['items'];

        foreach ($results as $result) {
            foreach ($result['artists'] as $artist) {
                if (str_slug($artist['name']) == str_slug('zeca pagodinho'))
                    dd($artist['id']);
            }
        }

        $seeder = SpotifySeed::addArtists(['4NHQUGzhtTLFvgF5SZesLK'])->addGenres(['classical', 'country'])->addTracks(['0c6xIDDpzE81m2q797ordA']);

        return SpotifyApi::recommendations($seeder)->limit(10)->get();
    }
}

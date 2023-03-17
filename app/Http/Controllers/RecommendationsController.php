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
        $songs = Song::take(2)->get();
        // return $songs->pluck('spotify_id');
        // try {
            
return $songs->pluck('artist.spotify_id');
        // $seeder = SpotifySeed::addArtists([$songs->first()->artist->spotify_id])->addGenres([$songs->first()->genre->name])->addTracks([$songs->first()->spotify_id]);      

        // $seeder = SpotifySeed::addArtists(['4NHQUGzhtTLFvgF5SZesLK'])->addGenres(['classical', 'country'])->addTracks(['0c6xIDDpzE81m2q797ordA']);

            $seeder = SpotifySeed::addArtists($songs->pluck('artist.spotify_id'))->addGenres($songs->pluck('genre.name'))->addTracks($songs->pluck('spotify_id'));

            return SpotifyApi::recommendations($seeder)->limit(10)->get();   
        // } catch (\Exception $e) {
            // bugreport($e);
        // }
    }
}

https://open.spotify.com/track/2WjLc16JdLH2V6FMk8VFsZ?si=5f57556745b746be
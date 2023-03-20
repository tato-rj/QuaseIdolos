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
        // return response(200);
        // return SpotifyApi::track('2WjLc16JdLH2V6FMk8VFsZ')->get();
        // return SpotifyApi::searchTracks('João Penca & Seus Miquinhos Amestrados - popstar')->limit(5)->get();
        $songs = auth()->user()->favorites()->take(3)->get() ?? Song::inRandomOrder()->take(3)->get();
return $songs;
        $seeder = SpotifySeed::addTracks($songs->pluck('spotify_id'));

        try {
            $results = SpotifyApi::recommendations($seeder)->limit(10)->get();

            foreach ($results['tracks'] as $result) {
                if (Song::bySpotifyId($result['id'])->exists()) {
                    return Song::bySpotifyId($result['id'])->first();
                }
            }
        } catch (\Exception $e) {
            dd($e);
            //bugreport($e);
        }

        return 'No songs found.';
    }
}
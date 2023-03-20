<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spotify as SpotifyApi;
use SpotifySeed;
use App\Tools\MusicData\MusicData;
use App\Models\Song;

class RecommendationsController extends Controller
{
    public function get(Request $request)
    {

        $songs = Song::whereIn('id', $request->ids ?? [])->get();
        // $songs = auth()->user()->favorites()->take(3)->get();
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
            //
        }

        return response(404);
    }
}
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

        $seeder = SpotifySeed::addTracks($songs->pluck('spotify_id'));

        try {
            $results = SpotifyApi::recommendations($seeder)->limit(20)->get();

            return Song::whereIn('spotify_id', collect($results['tracks'])->pluck('id'))->get();
            // $songs = Song::whereIn()
            foreach ($results['tracks'] as $result) {
                if (Song::bySpotifyId($result['id'])->exists()) {
                    $song = Song::bySpotifyId($result['id'])->first();

                    return view('pages.cardapio.results.table', compact(['songs']))->render();
                }
            }
        } catch (\Exception $e) {
            //
        }
    }
}
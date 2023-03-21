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
            $results = SpotifyApi::recommendations($seeder)->limit(50)->get();

            $song = Song::whereIn('spotify_id', collect($results['tracks'])->pluck('id'))->inRandomOrder()->first();

            return view('pages.cardapio.components.recommendations.result', compact(['song']))->render();
        } catch (\Exception $e) {
            //
        }
    }
}
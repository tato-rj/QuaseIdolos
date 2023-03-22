<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spotify as SpotifyApi;
use SpotifySeed;
use App\Tools\MusicData\MusicData;
use App\Models\Song;

class RecommendationsController extends Controller
{
    public function choices()
    {
        $choices = Song::top(20)->get()->shuffle()->take(12);

        return view('pages.cardapio.components.recommendation.choices', compact('choices'))->render();
    }

    public function get(Request $request)
    {
        $songs = Song::whereIn('id', $request->ids ?? [])->get();

        $seeder = SpotifySeed::addTracks($songs->pluck('spotify_id'));

        try {
            $results = SpotifyApi::recommendations($seeder)->limit(50)->get();

            $song = local() ? Song::inRandomOrder()->first() : Song::whereIn('spotify_id', collect($results['tracks'])->pluck('id'))->inRandomOrder()->first();

            $song = $song ?? Song::first();
            return view('pages.cardapio.components.recommendation.result', compact(['song']))->render();
        } catch (\Exception $e) {
            //
        }
    }
}
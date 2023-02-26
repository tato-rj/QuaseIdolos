<?php

namespace App\Tools\MusicData\Providers;

use Spotify as SpotifyApi;

trait Spotify
{
	public function searchFor($input)
	{
		$response = SpotifyApi::searchTracks($input)->limit(1)->get()['tracks'];

		if (count($response['items']))
			return $response['items'][0];
	}

	public function findSong($songId)
	{
		return SpotifyApi::audioFeaturesForTrack($songId)->get();
	}
}
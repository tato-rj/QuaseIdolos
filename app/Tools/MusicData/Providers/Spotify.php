<?php

namespace App\Tools\MusicData\Providers;

use Spotify as SpotifyApi;

trait Spotify
{
	public function searchFor($input)
	{
		$response = SpotifyApi::searchTracks($input)->limit(10)->get()['tracks'];

		if (count($response['items'])) {
			foreach($response['items'] as $index => $result) {
				if (str_slug($result['artists'][0]['name']) == str_slug($this->artist))
					return $response['items'][$index];
			}
		}
	}

	public function findSong($songId)
	{
		return SpotifyApi::audioFeaturesForTrack($songId)->get();
	}
}
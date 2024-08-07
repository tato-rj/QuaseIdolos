<?php

namespace App\Tools\MusicData\Providers;

use Spotify as SpotifyApi;

trait Spotify
{
	public function searchFor($input)
	{
		// dd(SpotifyApi::audioFeaturesForTrack('7HVkDgjIDN9TCyjzjZu1Fs')->get());
		$response = SpotifyApi::searchTracks($input)->limit(10)->get()['tracks'];

		if (count($response['items'])) {
			foreach($response['items'] as $index => $result) {
				if ($result['preview_url'] && $this->closeEnough($result['artists'][0]['name'], $this->artist))
					return $response['items'][$index];
			}
		}
	}

	public function findSong($songId)
	{
		return SpotifyApi::audioFeaturesForTrack($songId)->get();
	}
}
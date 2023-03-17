<?php

namespace App\Tools\MusicData;

use App\Tools\MusicData\Providers\Spotify;

class MusicData
{
	use Spotify;

	protected $data, $artist, $song;

	public function __construct()
	{
		$this->data = collect();
	}

	public function artist($artist)
	{
		$this->artist = $artist;

		return $this;
	}

	public function song($song)
	{
		$this->song = $song;

		return $this;
	}

	public function get()
	{
		$query = $this->searchFor($this->song . ' - ' . $this->artist);

		if ($query)
			$this->createDataFrom($query);

		return $this->data;
	}

	public function createDataFrom(array $query)
	{
		$song = $this->findSong($query['id']);
		$artist = $this->findArtist($query['artists']);

		$this->data->put('artist_id', $artist['id'] ?? null);
		$this->data->put('bpm', round($song['tempo']));
		$this->data->put('preview_url', $query['preview_url']);
		$this->data->put('duration', round(($song['duration_ms']/1000)/60));
	}

	public function findArtist(array $artists)
	{
		foreach ($artists as $artist) {
			if (str_slug($artist['name']) == str_slug($this->artist))
				return $artist;
		}
	}

	public function closeEnough($nameA, $nameB)
	{
		$nameA = str_slug($nameA);
		$nameB = str_slug($nameB);

		similar_text($nameA, $nameB, $percent);

		return $percent > 85;
	}
}
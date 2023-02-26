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

		$this->data->put('bpm', round($song['tempo']));
		$this->data->put('preview_url', $query['preview_url']);
		$this->data->put('duration', round(($song['duration_ms']/1000)/60));
	}

	public function nameMatch($nameA, $nameB)
	{
		$nameA = str_slug($nameA);
		$nameB = str_slug($nameB);

		return $nameA == $nameB || str_contains($nameA, $nameB) || str_contains($nameB, $nameA);
	}
}
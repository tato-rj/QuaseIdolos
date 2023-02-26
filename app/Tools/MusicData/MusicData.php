<?php

namespace App\Tools\MusicData;

use App\Tools\MusicData\Providers\Spotify;

class MusicData
{
	use Spotify;

	protected $data;

	public function __construct()
	{
		$this->data = collect();
	}

	public function song($input)
	{
		$query = $this->searchFor($input);
return $query;
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
}
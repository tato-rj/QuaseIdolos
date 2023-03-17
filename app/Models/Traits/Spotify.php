<?php

namespace App\Models\Traits;

trait Spotify
{
	public function hasSpotifyId()
	{
		return (bool) $this->spotify_id;
	}
}
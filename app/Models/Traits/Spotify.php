<?php

namespace App\Models\Traits;

trait Spotify
{
	public function hasSpotifyId()
	{
		return (bool) $this->spotify_id;
	}

	public function scopeBySpotifyId($query, $id)
	{
		return $query->where('spotify_id', $id)->get();
	}
}
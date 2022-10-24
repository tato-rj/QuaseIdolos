<?php

namespace App\Models;

class Song extends BaseModel
{
	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'song_user', 'song_id');
	}

	public function favorites()
	{
		return $this->belongsToMany(User::class, 'favorites');
	}

	public function tags()
	{
		return explode(' ', $this->tags);
	}

	public function scopeSearch($query, $input)
	{
		return $query
			->where('name', 'LIKE', '%'.$input.'%')
			->orWhereHas('artist', function($q) use ($input) {
				$q->where('name', 'LIKE', '%'.$input.'%');
			});
	}
}

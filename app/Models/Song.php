<?php

namespace App\Models;

class Song extends BaseModel
{
	protected $withCount = ['favorites', 'setlists'];

	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

    public function setlists()
    {
        return $this->hasMany(Setlist::class);
    }

	public function favorites()
	{
		return $this->belongsToMany(User::class, 'favorites');
	}

    public function getCompletedCountAttribute()
    {
        return $this->setlists()->whereNotNull('finished_at')->count();
    }

    public function setlistPosition()
    {
    	$time = Setlist::waitingFor($this)->first()->created_at;

    	$count = Setlist::waiting()->where('created_at', '<', $time)->count();

    	return $count;
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

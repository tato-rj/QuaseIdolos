<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Gig extends BaseModel
{
	protected $dates = ['starts_at', 'ends_at', 'date'];
	protected $casts = [
		'is_live' => 'boolean',
		'is_paused' => 'boolean'
	];

	public function creator()
	{
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function scopeByEventDate($query)
	{
		return $query->orderBy('date', 'desc');
	}

    public function setlists()
    {
    	return $this->hasMany(Setlist::class);
    }

	public function scopeLive($query)
	{
		return $query->where('is_live', true);
	}

	public function isToday()
	{
		return $this->date->isSameDay(now());
	}

	public function isFull()
	{
		return $this->setlists->count() == $this->songs_limit;
	}

	public function getFullNameAttribute()
	{
		return $this->date ? $this->name : $this->name . ' ' . $this->dateForHumans;
	}

	public function getDateForHumansAttribute()
	{
		return $this->date ? $this->date->format('j/n/y') : null;
	}

	public function getIsOverAttribute()
	{
		return $this->ends_at;
	}

	public function getStatusAttribute()
	{
		if ($this->is_paused)
			return fa('circle', 'yellow', 'mr-2').'Pausado';

		if ($this->is_live)
			return fa('circle', 'green', 'mr-2').'Live!';

		if ($this->is_over)
			return fa('calendar-day', 'white', 'mr-2').'Terminou ' .$this->ends_at->diffForHumans();

		if (! $this->date)
			return fa('circle', 'red', 'mr-2').'Sem data';

		if ($this->date->lte(now()))
			return fa('circle', 'yellow', 'mr-2').'Esperando pra começar';

		return fa('calendar-day', 'white', 'mr-2').'Começa ' .$this->date->diffForHumans();
	}

	public function scopeReady($query)
	{
		$start = now()->copy()->startOfDay();

		return $query->whereDate('date', $start)->orWhereBetween('date', [$start, $start->addDay()->addHours(4)]);
	}

	public function isReady()
	{
		return $this->date && 
			($this->date->isSameDay(now()) || now()->between($this->date, $this->date->addDay()->addHours(4)));
	}
}

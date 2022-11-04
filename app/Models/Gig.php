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

    public function setlist()
    {
    	return $this->hasMany(SongRequest::class, 'gig_id');
    }
    
	public function scopeByEventDate($query)
	{
		return $query->orderBy('date', 'desc');
	}

	public function scopeLive($query)
	{
		return $query->where('is_live', true);
	}

	public function scopeUnscheduled($query)
	{
		return $query->whereNull('date');
	}

	public function duplicate()
	{
        $new = $this->replicate();

        $new->creator_id = auth()->user()->id;
        $new->date = null;
        $new->starts_at = null;
        $new->ends_at = null;
        $new->is_live = false;
        $new->is_paused = false;

        $new->push();
	}

	public function isToday()
	{
		return $this->date->isSameDay(now());
	}

	public function isPaused()
	{
		return $this->is_paused;
	}

	public function isLive()
	{
		return $this->is_live;
	}

	public function isFull()
	{
		if (is_null($this->songs_limit))
			return false;

		return $this->setlist->count() == $this->songs_limit;
	}

	public function userLimitReached()
	{
		if (is_null($this->songs_limit_per_user))
			return false;

		return $this->setlist()->where('user_id', auth()->user()->id)->count() == $this->songs_limit_per_user;
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
			return fa('circle', 'green', 'mr-2').'Ao vivo!';

		if ($this->is_over)
			return fa('calendar-day', 'white', 'mr-2').'Terminou ' .$this->ends_at->diffForHumans();

		// if (! $this->date)
			// return fa('circle', 'yellow', 'mr-2').'Sem data';

		if (! $this->date || $this->date->lte(now()))
			return fa('circle', 'yellow', 'mr-2').'Esperando pra começar';

		return fa('calendar-day', 'white', 'mr-2').'Começa ' .$this->date->diffForHumans();
	}

	public function scopeReady($query)
	{
		$start = now()->copy()->startOfDay();

		return $query->whereNull('date')
					 ->orWhereDate('date', $start)
					 ->orWhereBetween('date', [$start, $start->addDay()->addHours(4)]);
	}

	public function isReady()
	{
		if (! $this->date)
			return true;

		return $this->date->isSameDay(now()) || now()->between($this->date, $this->date->addDay()->addHours(4));
	}
}

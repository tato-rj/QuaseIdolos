<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\{Rateable, Archiveable};
use App\Voting\{Ranking, Rules};

class Gig extends BaseModel
{
	use Rateable, Archiveable;

	protected $dates = ['starts_at', 'ends_at', 'scheduled_for'];
	protected $casts = [
		'is_live' => 'boolean',
		'is_paused' => 'boolean',
		'is_private' => 'boolean'
	];

	public function creator()
	{
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function venue()
	{
		return $this->belongsTo(Venue::class);
	}

	public function winner()
	{
		return $this->belongsTo(SongRequest::class);
	}

	public function participants()
	{
		return $this->belongsToMany(User::class, 'participants');
	}

    public function setlist()
    {
    	return $this->hasMany(SongRequest::class, 'gig_id');
    }

    public function ratings()
    {
    	return $this->hasManyThrough(Rating::class, SongRequest::class);
    }

    public function name()
    {
    	return $this->name ?? $this->venue->name;
    }
    
    public function description()
    {
    	return $this->description ?? $this->venue->description;
    }
    
	public function scopeByEventDate($query)
	{
		return $query->orderBy('scheduled_for', 'desc');
	}

	public function scopeUnscheduled($query)
	{
		return $query->whereNull('scheduled_for');
	}

	public function scopeLive($query)
	{
		return $query->where('is_live', true);
	}

	public function scopeOrLive($query)
	{
		return $query->orWhere('is_live', true);
	}

    public function scopeUpcoming($query)
    {
    	return $query->where('scheduled_for', '>=', now()->startOfDay());
    }

    public function scopePublic($query)
    {
		return $query->where('is_private', false);
    }

    public function sortSetlist()
    {
        $this->setlist()->waiting()->get()->each(function($songRequest, $index) {
            $songRequest->update(['order' => $index]);
        });
    }

    public function ranking()
    {
    	if (! $this->participatesInRatings())
    		return null;
    	
    	return (new Ranking)->getVotes($this->ratings)->create();
    }

    public function rules($global = false)
    {
    	return (new Rules($this))->isGlobal($global)->create();
    }

	public function duplicate()
	{
        $new = $this->replicate();

        $new->creator_id = auth()->user()->id;
        $new->scheduled_for = null;
        $new->starts_at = null;
        $new->ends_at = null;
        $new->is_live = false;
        $new->is_paused = false;

        $new->push();
	}

	public function isToday()
	{
		if (! $this->hasDate())
			return null;

		return $this->scheduled_for->isSameDay(now());
	}

	public function isPrivate()
	{
		return (bool) $this->is_private;
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

	public function repeatLimitReachedFor(Song $song)
	{
		if (is_null($this->repeat_limit))
			return false;

		$count = $this->setlist()->whereHas('song', function($q) use ($song) {
			$q->where('song_id', $song->id);
		})->count();

		return $count > $this->repeat_limit;
	}

	public function getFullNameAttribute()
	{
		return $this->name;
	}

	public function getDateForHumansAttribute()
	{
		$weekday = weekday($this->scheduled_for->dayOfWeek);
		$month = month($this->scheduled_for->month);

		return $weekday . ', ' . $this->scheduled_for->day . ' de ' . $month;
	}

	public function getIsOverAttribute()
	{
		return $this->ends_at;
	}

	public function getDateInContextAttribute()
	{
		if (! $this->hasDate())
			return null;

		if ($this->scheduled_for->isToday())
			return 'Hoje';

		if ($this->scheduled_for->isYesterday())
			return 'Ontem';

		if ($this->scheduled_for->isTomorrow())
			return 'Amanhã';

		return $this->dateForHumans;
	}

	public function getStatusAttribute()
	{
		if (! $this->hasDate())
			return fa('circle', 'grey', 'mr-2').'Sem data';

		if ($this->is_paused)
			return fa('circle', 'yellow', 'mr-2').'Pausado';

		if ($this->is_live)
			return fa('circle', 'green', 'mr-2').'Ao vivo!';

		if ($this->is_over)
			return fa('calendar-day', 'white', 'mr-2').'Terminou ' .$this->ends_at->diffForHumans();

		if ($this->isReady())
			return fa('circle', 'yellow', 'mr-2').'Esperando pra começar';

		return fa('calendar-day', 'white', 'mr-2').'Começa ' .$this->scheduled_for->diffForHumans();
	}

	public function scopeReady($query)
	{
		$today = now()->copy()->startOfDay();

		return $query->whereBetween('scheduled_for', [$today->copy()->subHour(), $today->addDay()->addHours(4)]);
	}

    public function scopeNotReady($query)
    {
		return $query->except($this->ready()->get('id'));
    }

	public function hasDate()
	{
		return (bool) $this->scheduled_for;
	}

	public function isReady()
	{
		if (! $this->hasDate())
			return null;

		return now()->between($this->scheduled_for, $this->scheduled_for->addDay()->addHours(4));
	}
}

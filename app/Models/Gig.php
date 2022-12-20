<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\{Rateable, Archiveable, GigStates};
use App\Voting\{Ranking, Rules};
use App\Tools\Gig\Status;

class Gig extends BaseModel
{
	use Rateable, Archiveable, GigStates;

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

	public function scopeScheduled($query)
	{
		return $query->whereNotNull('scheduled_for');
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

    public function scopePast($query)
    {
    	return $query->where('scheduled_for', '<', now()->startOfDay());
    }

    public function scopeOrPast($query)
    {
    	return $query->orWhere('scheduled_for', '<', now()->startOfDay());
    }

    public function scopePublic($query)
    {
		return $query->where('is_private', false);
    }

    public function songRequestsLeft()
    {
    	if ($this->songs_limit)
	    	return $this->songs_limit - $this->setlist()->count();

	    return null;
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
		return $this->dateForHumans();
	}

	public function dateForHumans($showWeek = true)
	{
		$weekday = weekday($this->scheduled_for->dayOfWeek);
		$month = month($this->scheduled_for->month);

		if ($showWeek)
			return $weekday . ', ' . $this->scheduled_for->day . ' de ' . $month;

		return $this->scheduled_for->day . ' de ' . $month;
	}

	public function dateInContext()
	{
		if ($this->isUnscheduled())
			return null;

		if ($this->scheduled_for->isToday())
			return 'Hoje';

		if ($this->scheduled_for->isYesterday())
			return 'Ontem';

		if ($this->scheduled_for->isTomorrow())
			return 'Amanhã';

		return $this->dateForHumans;
	}

	public function status($withText = true)
	{
		return (new Status($this))->withText($withText)->get();
	}

	public function scopeReady($query)
	{
		$today = now()->copy()->startOfDay();

		return $query->whereDate('scheduled_for', '>=', $today)
					 ->whereDate('scheduled_for', '<', $today->addDay()->addHours(4));
	}

    public function scopeNotReady($query)
    {
		return $query->except($this->ready()->get('id'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\Rateable;

class Gig extends BaseModel
{
	use Rateable;
	
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

    public function scopeUpcoming($query)
    {
    	return $query->where('scheduled_for', '>=', now()->startOfDay());
    }

    public function scopePublic($query)
    {
		return $query->where('is_private', false);
    }

    public function ranking()
    {
    	if (! $this->participatesInRatings())
    		return null;
    	
    	$results = collect();

        $collection = $this->ratings;

        $uniqueVotes = $this->ratings->groupBy('user_id');

        $results->totalCount = $collection->count();

        $results->votersCount = $uniqueVotes->count();

        $ratings = collect();

        $collection->groupBy('song_request_id')->map(function($item, $index) use ($ratings) {
        	$entry = collect();
            $entry->songRequest = $item->first()->songRequest;
            $entry->average = $item->first()->songRequest->score(true);
            $entry->count = $item->count();

            $ratings->push($entry);
        });

        $results->ratings = $ratings->sortByDesc('average')->values();

        $results->winner = $ratings->first() ? $ratings->first()->songRequest : null;

        return $results;
    }

    public function rules()
    {
    	$voting = $this->participatesInRatings() ? 
    		'Este evento está aberto pra votação' : 
    		'Este evento não está aberto pra votação';
		
		$userLimit = $this->songs_limit_per_user ? 'Limite de '.$this->songs_limit_per_user. ' ' . trans_choice('plurais.música', $this->songs_limit_per_user) . ' por pessoa' : null;

		$songsLimit = $this->songs_limit ? 'Limite total de '.$this->songs_limit. ' ' . trans_choice('plurais.música', $this->songs_limit) : null;

		$repetitionUser = 'Ninguém pode cantar a mesma música mais de uma vez';

		if ($this->repeat_limit == 0) {
			$repetitionLimit = 'Uma música não pode ser escolhida mais de uma vez no programa';
		} else if ($this->repeat_limit == 1) {
			$repetitionLimit = 'Uma música só pode ser repetida até 1 vez no programa';
		} else {
			$repetitionLimit = 'Uma música só pode ser repetida até '.$this->repeat_limit.' vezes no programa';
		}

		return collect([
			$voting, $userLimit, $songsLimit, $repetitionUser, $repetitionLimit
		]);
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
		return $this->scheduled_for->format('j/n/y');
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
		$start = now()->copy()->startOfDay();

		return $query->whereDate('scheduled_for', $start)
					 ->orWhereBetween('scheduled_for', [$start->copy()->subDay(), $start->addHours(4)]);
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

		return $this->scheduled_for->isSameDay(now()) || now()->between($this->scheduled_for, $this->scheduled_for->addDay()->addHours(4));
	}
}

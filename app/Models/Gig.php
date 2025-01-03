<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\{Rateable, Archiveable, GigStates, Chateable, Sortable};
use App\Voting\{Ranking, Rules};
use App\Tools\Gig\{Status, Password};

class Gig extends EventModel
{
	use Rateable, Archiveable, GigStates, Chateable, Sortable;

	protected $casts = [
        'set_is_full' => 'boolean',
		'is_live' => 'boolean',
		'is_paused' => 'boolean',
		'is_private' => 'boolean',
		'is_test' => 'boolean',
		'participates_in_chat' => 'boolean',
		'has_ratings' => 'boolean'
	];

    public function musicians()
    {
        return $this->belongsToMany(User::class, 'gig_users', 'gig_id', 'user_id')->with('admin')->orderBy('users.name');
    }

	public function winner()
	{
		return $this->belongsTo(SongRequest::class);
	}

	public function participants()
	{
		return $this->hasMany(Participant::class)->latest();
	}

    public function setlist()
    {
    	return $this->hasMany(SongRequest::class, 'gig_id');
    }

    public function sets()
    {
        return $this->hasMany(Set::class)->latest();
    }

    public function chats()
    {
    	return $this->hasMany(Chat::class);
    }

    public function ratings()
    {
    	return $this->hasManyThrough(Rating::class, SongRequest::class);
    }

    public function isKareoke()
    {
    	return true;
    }

    public function isShow()
    {
    	return false;
    }

    public function getUnknownSongsAttribute()
    {
        return $this->musicians->pluck('admin.unknown_songs')->collapse()->unique()->values();
    }

    public function openRoute()
    {
    	return route('gig.open', $this);
    }

    public function closeRoute()
    {
    	return route('gig.close', $this);
    }
    
    public function password()
    {
    	return new Password($this);
    }

    public function scopeInSubdomain($query)
    {
    	if (! subdomain())
    		return $query;
    	
    	return $query->whereHas('venue', function($q) {
    		$q->uid(subdomain());
    	});
    }

    public function scopePublic($query)
    {
		return $query->where('is_private', false);
    }

    public function scopeLive($query)
    {
        return $query->where('is_live', true);
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
        $new->winner_id = null;
        $new->is_live = false;
        $new->is_paused = false;
        $new->set_limit = $this->set_limit;
        $new->password = $this->password()->required() ? $this->password()->generate() : null;

        $new->push();

        $new->musicians()->sync($this->musicians->pluck('id')->toArray());
	}

    public function canPlay(Song $song)
    {
        // if ($this->excluded_songs)
            // return ! in_array($song->id, $this->excluded_songs);

        return true;
    }

    public function excludedSongs()
    {
        $musicians = $this->musicians()->whereHas('admin', function($q) {
            $q->whereNotNull('unknown_songs');
        })->get();

        return Song::findMany($musicians->pluck('admin.unknown_songs')->flatten()->unique());
    }

	public function userLimitReached()
	{
		if (! $this->songs_limit_per_user)
			return false;

		return $this->setlist()->where('user_id', auth()->user()->id)->count() >= $this->songs_limit_per_user;
	}

    // public function incrementSet(SongRequest $songRequest)
    // {
    //     if ($songRequest->user->admin()->exists())
    //         return $this;
        
    //     if (! $this->setHasReachedItsLimit())
    //         $this->increment('set_counter');
        
    //     if ($this->setHasReachedItsLimit())
    //         $this->update(['set_is_full' => true]);
    // }

    // public function decrementSet(SongRequest $songRequest)
    // {
    //     if (! $this->set_is_full || $songRequest->user->admin()->exists())
    //         return $this;
        
    //     if ($this->set_counter > 0)
    //         $this->decrement('set_counter');
        
    //     $this->resetSet();
    // }

    public function updateSet($canceled = false)
    {
        $currentSet = $this->sets()->current();

        if ($canceled) {
            $currentSet->increment('songs_left');

            if ($this->sets()->exists() && $currentSet->songsLeft() > 0)
                $currentSet->update(['finished' => false]);
        }

        if ($this->sets()->exists() && $currentSet->isFull() && ! $this->setlist()->waiting()->exists())
            $currentSet->renew();
    }

    // public function checkSetLimit()
    // {
    //     if (! $this->current_set_limit)
    //         return null;

    //     $songsWaiting = $this->setlist()->byGuests()->waiting()->count();

    //     $isFull = $songsWaiting >= $this->current_set_limit;

    //     if ($isFull) {
    //         $this->update(['set_is_full' => true]);
    //     } else if ($songsWaiting == 0) {
    //         $this->update([
    //             'current_set_limit' => $this->set_limit,
    //             'set_is_full' => false
    //         ]);
    //     }
    // }

	public function repeatLimitReachedFor(Song $song)
	{
		if (is_null($this->repeat_limit))
			return false;

		$count = $this->setlist()->whereHas('song', function($q) use ($song) {
			$q->where('song_id', $song->id);
		})->count();

		return $count > $this->repeat_limit;
	}

	public function status()
	{
		return (new Status($this));
	}

	public function scopeReady($query)
	{
		$admin = auth()->check() ? auth()->user()->admin()->exists() || auth()->user()->isTester() : false;
		$today = now()->copy()->startOfDay();

		if (! $admin)
			$query->where(['is_test' => false]);

		return $query->where(function($q) use ($today) {
						$q->whereDate('scheduled_for', '>=', $today);
						$q->whereDate('scheduled_for', '<', $today->addDay()->addHours(4));
						$q->orWhere('is_live', true);
					 });
	}

    public function close($confirmRequests = false)
    {
        $this->update([
            'is_live' => false,
            'is_paused' => false,
            'ends_at' => now()
        ]);

        if ($confirmRequests) {
			$this->setlist()->waiting()->get()->each->finish();
        } else {
        	$this->setlist()->waiting()->delete();
        }

        Participant::in($this)->unconfirmed()->confirm();

        $this->archives()->save();

        return $this;
    }
}

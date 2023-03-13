<?php

namespace App\Models;

use App\Tools\Gig\{Status, Password};
use App\Models\Traits\{GigStates, Chateable, Rateable};

class Show extends EventModel
{
    use GigStates, Chateable, Rateable;

    protected $casts = [
        'is_live' => 'boolean',
        'is_paused' => 'boolean'
    ];

    public function musicians()
    {
        return $this->belongsToMany(User::class, 'show_user', 'show_id', 'user_id')->orderBy('users.name');
    }

    public function setlist()
    {
        return $this->hasMany(Setlist::class, 'show_id')->orderBy('order');
    }

    public function status()
    {
        return (new Status($this));
    }

    public function password()
    {
        return new Password($this);
    }

    public function isKareoke()
    {
        return false;
    }

    public function isShow()
    {
        return true;
    }

    public function reorderSetlist($order = [])
    {
        foreach ($this->setlist as $key => $song) {
            $song->pivot->update(['order' => 1]);
        }
        
        // $this->setlist->each(function($song, $index) {
        //     $song->pivot->update(['order' => $index + 1]);
        // });
    }


    public function openRoute()
    {
        return route('shows.open', $this);
    }

    public function closeRoute()
    {
        return route('shows.close', $this);
    }

    public function close($confirmRequests = false)
    {
        $this->update([
            'is_live' => false,
            'is_paused' => false,
            'ends_at' => now()
        ]);

        // $this->archives()->save();

        return $this;
    }

    public function scopeReady($query)
    {
        $today = now()->copy()->startOfDay();

        return $query->where(function($q) use ($today) {
                        $q->whereDate('scheduled_for', '>=', $today);
                        $q->whereDate('scheduled_for', '<', $today->addDay()->addHours(4));
                        $q->orWhere('is_live', true);
                     });
    }
}

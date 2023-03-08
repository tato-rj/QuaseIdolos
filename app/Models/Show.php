<?php

namespace App\Models;

use App\Tools\Gig\{Status, Password};
use App\Models\Traits\GigStates;

class Show extends EventModel
{
    use GigStates;

    protected $casts = [
        'is_live' => 'boolean',
        'is_paused' => 'boolean'
    ];

    public function musicians()
    {
        return $this->belongsToMany(User::class, 'show_users', 'show_id', 'user_id')->orderBy('users.name');
    }

    public function setlist()
    {
        return $this->belongsToMany(Song::class, 'show_songs', 'show_id', 'song_id')
                    ->with(['artist'])
                    ->withTimestamps()
                    ->orderBy('show_songs.order');
    }

    public function status()
    {
        return (new Status($this));
    }

    public function password()
    {
        return new Password($this);
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

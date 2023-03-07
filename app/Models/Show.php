<?php

namespace App\Models;

class Show extends EventModel
{
    protected $casts = [
        'is_live' => 'boolean',
        'is_paused' => 'boolean'
    ];

    public function setlist()
    {
        return $this->belongsToMany(Song::class, 'show_songs', 'show_id', 'song_id')
                    ->with(['artist'])
                    ->withTimestamps()
                    ->orderBy('show_songs.order');
    }
}

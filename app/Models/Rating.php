<?php

namespace App\Models;

class Rating extends BaseModel
{
    public function songRequest()
    {
        return $this->belongsTo(SongRequest::class);    
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFrom($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeTo($query, User $user)
    {
        return $query->whereHas('songRequest', function($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    public function scopeFor($query, SongRequest $songRequest)
    {
        return $query->where('song_request_id', $songRequest->id);
    }

    public function scopeForSong($query, Song $song)
    {
        return $query->whereHas('songRequest', function($q) use ($song) {
            $q->where('song_id', $song->id);
        });
    }

    public function tooManyAttempts()
    {
        return $this->attempts == 2;
    }
}

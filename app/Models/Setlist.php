<?php

namespace App\Models;

class Setlist extends BaseModel
{
    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWaiting($query)
    {
        return $query->whereNull('finished_at');
    }

    public function scopeWaitingFor($query, Song $song)
    {
        return $query->waiting()->where('song_id', $song->id);
    }

    public function add(User $user, Song $song)
    {
        return $this->create(['user_id' => $user->id, 'song_id' => $song->id]);
    }

    public function finish()
    {
        $this->update(['finished_at' => now()]);
    }
}

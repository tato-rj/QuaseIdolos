<?php

namespace App\Models;

class Favorite extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function scopeBySong($query, Song $song)
    {
        return $query->where('song_id', $song->id);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}

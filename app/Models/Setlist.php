<?php

namespace App\Models;

class Setlist extends BaseModel
{
    protected $casts = [
        'finished_at' => 'date'
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFrom($query, User $user)
    {
        return $this->where('user_id', $user->id);
    }

    public function scopeWaiting($query)
    {
        return $query->whereNull('finished_at')->orderBy('order');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('finished_at');
    }

    public function scopeWaitingFor($query, Song $song)
    {
        return $query->waiting()->where([
            ['song_id', $song->id],
            ['user_id', auth()->user()->id]
        ]);
    }

    public function add(User $user, Song $song)
    {
        return $this->create([
            'user_id' => $user->id, 
            'song_id' => $song->id,
            'order' => $this->waiting()->count()]);
    }

    public function finish()
    {
        $this->update(['finished_at' => now()]);
    }

    public function isOver()
    {
        return (bool) $this->finished_at;
    }
}

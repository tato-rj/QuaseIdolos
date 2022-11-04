<?php

namespace App\Models;

class SongRequest extends BaseModel
{
    protected $dates = ['finished_at'];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

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

    public function scopeForGig($query, Gig $gig)
    {
        return $this->where('gig_id', $gig->id);
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

    public function wasRequestedBy(User $user)
    {
        return $this->user_id == $user->id;
    }
    
    public function add(User $user, Song $song, Gig $gig)
    {
        return $this->create([
            'user_id' => $user->id, 
            'song_id' => $song->id,
            'gig_id' => $gig->id,
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

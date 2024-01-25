<?php

namespace App\Models;

class Set extends BaseModel
{
    protected $casts = ['finished' => 'boolean'];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function scopeNew($query, Gig $gig)
    {
        $query->create([
            'gig_id' => $gig->id,
            'limit' => $gig->set_limit,
            'songs_left' => $gig->set_limit
        ]);
    }

    public function renew()
    {
        return $this->update([
            'queue' => 0,
            'limit' => $this->gig->set_limit,
            'songs_left' => $this->gig->set_limit,
            'finished' => false
        ]);
    }

    public function scopeCurrent($query)
    {
        return $query->first();
    }

    public function incrementQueue()
    {
        $this->increment('queue');

        if ($this->limit)
            $this->decrement('songs_left');

        if ($this->isFull())
            $this->update(['finished' => true]);
    }

    public function decrementQueue()
    {
        if ($this->queue > 0)
           $this->decrement('queue');
    }

    public function songsLeft()
    {
        return $this->songs_left;
        // return $this->limit - $this->queue;
    }

    public function isFull()
    {
        return $this->songs_left <= 0;
        // return $this->limit <= $this->queue;
    }

    public function isFinished()
    {
        // return $this->isFull();
        return $this->finished;
    }
}

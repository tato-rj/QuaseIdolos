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
            'limit' => $gig->set_limit
        ]);
    }

    public function renew()
    {
        return $this->update([
            'queue' => 0,
            'limit' => $this->gig->set_limit,
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
        return $this->limit - $this->queue;
    }

    public function isFull()
    {
        return $this->limit <= $this->queue;
    }

    public function isFinished()
    {
        return $this->finished;
    }
}

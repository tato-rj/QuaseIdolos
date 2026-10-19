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
        $waiting = $gig->setlist()->waiting()->count();

        return $query->create([
            'gig_id' => $gig->id,
            'limit' => $gig->set_limit,
            'songs_left' => $gig->set_limit - $waiting,
            'queue' => $waiting,
            'finished' => $waiting >= $gig->set_limit,
        ]);
    }

    public function changeLimit(int $limit)
    {
        $waiting = $this->gig->setlist()->waiting()->count();

        // The total includes songs already confirmed in THIS set, not just its queue.
        // Waiting requests also protect sets created by older code without counters.
        $total = max($waiting, $this->limit - $this->songs_left, 0);

        return $this->update([
            'limit' => $limit,
            'songs_left' => $limit - $total,
            'queue' => $waiting,
            'finished' => $total >= $limit,
        ]);
    }

    public function returnSlot(int $waiting)
    {
        // Cancel exactly one accepted song. Never forget the remaining queue or
        // allow a legacy counter to produce a negative displayed set total.
        $total = max($waiting, $this->limit - $this->songs_left - 1, 0);

        return $this->update([
            'songs_left' => $this->limit - $total,
            'queue' => $waiting,
            'finished' => $total >= $this->limit,
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

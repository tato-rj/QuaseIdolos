<?php

namespace App\Models;

class Participant extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGuests($query)
    {
        return $query->whereHas('user', function($q) {
            $q->doesntHave('admin');
        });
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function scopeIn($query, Gig $gig)
    {
        return $query->where('gig_id', $gig->id);
    }

    public function scopeBy($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('created_at');
    }

    public function scopeUnconfirmed($query)
    {
        return $query->whereNull('created_at');
    }

    public function scopeConfirm($query)
    {
        return $query->update(['created_at' => now()]);
    }
}

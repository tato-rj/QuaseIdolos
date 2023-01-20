<?php

namespace App\Models;

class Musician extends BaseModel
{
    protected $table = 'gig_users';

    public function scopeGig($query, Gig $gig)
    {
        return $query->where('gig_id', $gig->id);
    }

    public function scopeUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}

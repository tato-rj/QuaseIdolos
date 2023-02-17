<?php

namespace App\Models;

class BlockedUser extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function by()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearchFor($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('by_id', $user->id);
    }
}

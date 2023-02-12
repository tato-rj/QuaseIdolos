<?php

namespace App\Models;

class Chat extends BaseModel
{
    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function scopeSender($query, User $user)
    {
        return $query->where('from_id', $user->id);
    }

    public function scopeRecipient($query, User $user)
    {
        return $query->where('to_id', $user->id);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead()
    {
        return $this->update(['read_at' => now()]);
    }
}

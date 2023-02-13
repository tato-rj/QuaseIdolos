<?php

namespace App\Models;

class Chat extends BaseModel
{
    protected $dates = ['read_at'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class);
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

    public function isRead()
    {
        return (bool) $this->read_at;
    }

    public function scopeBetween($query, User $userOne, User $userTwo)
    {
        $firstQuery = $this->sender($userOne)->recipient($userTwo);

        return $query->recipient($userOne)->sender($userTwo)->union($firstQuery)->orderBy('created_at');
    }
}

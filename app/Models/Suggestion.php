<?php

namespace App\Models;

class Suggestion extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnconfirmed($query)
    {
    	return $query->whereNull('confirmed_at');
    }

    public function confirm()
    {
        return $this->update(['confirmed_at' => now()]);
    }
}

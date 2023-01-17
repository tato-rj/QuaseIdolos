<?php

namespace App\Models;

class SocialAccount extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBySocialId($query, $id)
    {
        return $query->where('social_id', $id);
    }

    public function scopeProvider($query, $provider)
    {
        return $query->where('social_provider', $provider);
    }
}

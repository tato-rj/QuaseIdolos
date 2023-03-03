<?php

namespace App\Models;

use App\Models\Traits\FindBySlug;

class Venue extends BaseModel
{
    use FindBySlug;

    protected $withCount = ['gigs'];
    
    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function gigsNotToday()
    {
        return $this->hasMany(Gig::class)->where('scheduled_for', '!=', now()->startOfDay());
    }

    public function scopeUid($query, $uid)
    {
        return $query->where('uid', $uid);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeExceptGigs($query, $gigs = [])
    {
        return $query->whereHas('gigs', function($q) use ($gigs) {
            $q->whereNotIn('id', $gigs);
        });
    }
}

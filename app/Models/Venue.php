<?php

namespace App\Models;

class Venue extends BaseModel
{
    protected $withCount = ['gigs'];
    
    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function gigsNotToday()
    {
        return $this->hasMany(Gig::class)->where('scheduled_for', '!=', now()->startOfDay());
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

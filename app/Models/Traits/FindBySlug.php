<?php

namespace App\Models\Traits;

trait FindBySlug
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeBySlug($query, $slug)
    {
    	return $query->where('slug', $slug);
    }
}

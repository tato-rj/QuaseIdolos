<?php

namespace App\Models\Traits;

trait Searchable
{
    public function scopeSearch($query, $input)
    {
        return $query->where('name', 'LIKE', '%'.$input.'%');
    }
}
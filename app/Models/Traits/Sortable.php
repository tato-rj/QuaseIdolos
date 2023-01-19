<?php

namespace App\Models\Traits;

trait Sortable
{
    public function scopeSortable($query)
    {
        return $query->orderBy(request()->sort_by ?? 'created_at', request()->order ?? 'desc');
    }
}
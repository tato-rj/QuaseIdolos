<?php

namespace App\Models\Traits;

trait Sortable
{
    public function scopeSortable($query, $sort = 'created_at', $order = 'desc')
    {
        return $query->orderBy(request()->sort_by ?? $sort, request()->order ?? $order);
    }
}
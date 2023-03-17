<?php

namespace App\Models\Traits;

trait Sortable
{
    public function scopeSortable($query, $sort = 'created_at', $order = 'desc')
    {
        $array = explode('.', request()->sort_by ?? $sort);

        if (count($array) == 1)
            return $query->orderBy(request()->sort_by ?? $sort, request()->order ?? $order);

        return $query->with($array[0], function($q) use ($array, $order) {
            $q->orderBy($array[1], request()->order ?? $order);
        });
    }

    // public function scopeDeepSortable($query, $relation, $sort = 'created_at', $order = 'desc')
    // {
    //     return $query->whereHas($relation, function($q) {

    //     });
    // }
}
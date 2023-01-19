<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\{BelongsToThrough, Sortable};

class BaseModel extends Model
{
    use HasFactory, BelongsToThrough, Sortable;

    public function scopeLast($query)
    {
        return $query->latest()->first();
    }

    public function scopeExcept($query, $ids = [])
    {
        return $query->whereNotIn('id', $ids);
    }
}
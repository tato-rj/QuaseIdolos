<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function scopeLast($query)
    {
        return $query->latest()->first();
    }

    public function scopeExcept($query, $ids = [])
    {
        return $query->whereNotIn('id', $ids);
    }
}
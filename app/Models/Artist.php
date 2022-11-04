<?php

namespace App\Models;

use App\Models\Traits\{Searchable, FindBySlug};

class Artist extends BaseModel
{
    use Searchable, FindBySlug;

    protected $withCount = ['songs'];

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('name');        
    }

    public function coverImage()
    {
        return asset('storage/' . $this->image_path);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }
}

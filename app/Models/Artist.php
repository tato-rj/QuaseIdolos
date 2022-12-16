<?php

namespace App\Models;

use App\Models\Traits\{Searchable, FindBySlug};

class Artist extends BaseModel
{
    use Searchable, FindBySlug;

    protected $appends = ['image'];
    protected $withCount = ['songs'];

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('name');
    }

    public function coverImage()
    {
        return asset('storage/' . $this->image_path);
    }

    public function getImageAttribute()
    {
        return $this->coverImage();
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeAlphabetically($query)
    {
        $collection = $query->get()->groupBy(function($artist) {
            return strtoupper(substr($artist->name, 0, 1));
        });

        return $collection->values();
    }
}

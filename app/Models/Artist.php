<?php

namespace App\Models;

class Artist extends BaseModel
{
    protected $withCount = ['songs'];
    
    protected static function booted()
    {
        self::deleting(function($artist) {
            \Storage::disk('public')->delete($artist->image_path);
            $artist->songs->each->delete();
        });
    }

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('name');        
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function coverImage()
    {
        return asset('storage/' . $this->image_path);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeSearch($query, $input)
    {
        return $query->where('name', 'LIKE', '%'.$input.'%');
    }
}

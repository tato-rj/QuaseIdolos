<?php

namespace App\Models;

use App\Models\Traits\FindBySlug;

class Genre extends BaseModel
{
    use FindBySlug;

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('name');        
    }
    
    public function songRequests()
    {
        return $this->hasManyThrough(SongRequest::class, Song::class);
    }
    
    public function coverImage()
    {
        return asset('storage/' . $this->image_path);
    }
}

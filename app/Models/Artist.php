<?php

namespace App\Models;

use App\Models\Traits\{Searchable, FindBySlug, HasAvatar};
use App\Tools\MusicData\MusicData;

class Artist extends BaseModel
{
    use Searchable, FindBySlug, HasAvatar;

    protected $appends = ['image'];
    protected $withCount = ['songs'];
    protected $casts = ['is_hidden' => 'boolean'];

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('name');
    }

    public function songRequests()
    {
        return $this->hasManyThrough(SongRequest::class, Song::class);
    }

    public function getImageAttribute()
    {
        return $this->coverImage();
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function isHidden()
    {
        return $this->is_hidden;
    }

    public function scopeAlphabetically($query)
    {
        $collection = $query->get()->groupBy(function($artist) {
            return strtoupper(substr($artist->name, 0, 1));
        });

        return $collection->values();
    }

    public function getMusicData()
    {
        $data = (new MusicData)->artist($this->name)->get();

        return $this->update([
            'spotify_id' => $data['artist_id'] ?? $this->spotify_id
        ]);
    }
}

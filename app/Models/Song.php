<?php

namespace App\Models;

use App\Models\Traits\{Archiveable, Sortable, Cardapio};
use App\Tools\MusicData\MusicData;

class Song extends BaseModel
{
	use Archiveable, Sortable, Cardapio;
	
	protected $withCount = ['favorites', 'songRequests'];
	protected $with = ['genre', 'artist'];

    protected static function booted()
    {
        self::creating(function(Song $song) {
            $song->chords_url = $song->generateChordsUrl();
        });
    }

	public function artist()
	{
		return $this->belongsTo(Artist::class);
	}

	public function genre()
	{
		return $this->belongsTo(Genre::class);
	}

    public function songRequests()
    {
        return $this->hasMany(SongRequest::class);
    }

    public function ratings()
    {
        return $this->hasManyThrough(Rating::class, SongRequest::class);
    }
    
	public function favorites()
	{
		return $this->belongsToMany(User::class, 'favorites');
	}

	public function generateChordsUrl()
	{
		return 'https://www.cifraclub.com.br/' . $this->artist->slug . '/' . str_slug($this->name);
	}

    public function getCompletedCountAttribute()
    {
        return $this->songRequests()->whereNotNull('finished_at')->count();
    }

    public function setlistPosition()
    {
    	return SongRequest::waitingFor($this)->first()->order;
    }

    public function scopeByGenre($query, $slug)
    {
    	return $query->whereHas('genre', function($q) use ($slug) {
    		$q->where('slug', $slug);
    	});
    }

    public function scopeByArtist($query, $slug)
    {
    	return $query->whereHas('artist', function($q) use ($slug) {
    		$q->where('slug', $slug);
    	});
    }

	public function scopeVisibleArtist($query)
	{
		return $query->whereHas('artist', function($q) {
				$q->visible();
			});
	}

    public function scopeAlphabetically($query)
    {
    	return $query->orderBy('name');
    }

    public function getMusicData()
    {
        $data = (new MusicData)->artist($this->artist->name)->song($this->name)->get();

        return $this->update([
            'duration' => $data['duration'] ?? $this->duration,
            'bpm' => $data['bpm'] ?? null,
            'preview_url' => $data['preview_url'] ?? null
        ]);
    }
}

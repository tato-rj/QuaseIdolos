<?php

namespace App\Models;

use App\Models\Traits\{Archiveable, Sortable, Cardapio, Spotify};
use App\Tools\MusicData\MusicData;

class Song extends BaseModel
{
	use Archiveable, Sortable, Cardapio, Spotify;
	
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

    public function drumScore()
    {
        return $this->drum_score_path ? asset('storage/' . $this->drum_score_path) : null;
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

    public function scopeTop($query, $count = null)
    {
        if (local())
            return $query->whereNotNull('spotify_id')->take($count);
        
        return $query->orderBy('song_requests_count', 'desc')->take($count);
    }

    public function scopeShouldShow($query)
    {
        if (auth()->check() && auth()->user()->liveGig) {
            return $query->whereNotIn('id', auth()->user()->liveGig->unknown_songs);
        } else {
            return $query;
        }
    }

    public function getMusicData()
    {
        $data = (new MusicData)->artist($this->artist->name)->song($this->name)->get();

        return $this->update([
            'spotify_id' => $data['song_id'] ?? $this->spotify_id,
            'duration' => $data['duration'] ?? $this->duration,
            'bpm' => $data['bpm'] ?? $this->bpm,
            'time_signature' => $data['time_signature'] ?? $this->time_signature,
            'preview_url' => $data['preview_url'] ?? $this->preview_url
        ]);
    }
}

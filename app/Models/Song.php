<?php

namespace App\Models;

use App\Models\Traits\Archiveable;

class Song extends BaseModel
{
	use Archiveable;
	
	protected $withCount = ['favorites', 'songRequests'];

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

    public function getLyricsCompactAttribute()
    {
        $paragraphs = explode("\n\n", $this->lyrics);

        if (count($paragraphs) <= 1)
        	$paragraphs = explode("\r\n\r\n", $this->lyrics);

        if (count($paragraphs) <= 1)
        	return $this->lyrics;

        foreach($paragraphs as $index => $paragraph) {
            $paragraphs[$index] = str_replace(['(2x)', '(3x)', '.'], '', $paragraph);
        }

        $index = 0;
        $refrain = null;

        foreach(array_count_values($paragraphs) as $paragraph => $count) {
            if ($count > 1) {
                $refrain = $paragraph;
                break;
            }

            $index += 1;
        }

        foreach($paragraphs as $key => $paragraph) {
            if ($paragraph == $refrain && $key != $index)
                $paragraphs[$key] = '+ REFRÃO';
        }

        return implode("\n\n", $paragraphs);
    }

    public function setlistPosition()
    {
    	return SongRequest::waitingFor($this)->first()->order;
    }

	public function scopeSearch($query, $input)
	{
		return $query
			->where('name', 'LIKE', '%'.$input.'%')
			->orWhereHas('genre', function($q) use ($input) {
				$q->where('name', 'LIKE', '%'.$input.'%');
			})
			->orWhereHas('artist', function($q) use ($input) {
				$q->where('name', 'LIKE', '%'.$input.'%');
			});
	}

    public function scopeAlphabetically($query)
    {
    	return $query->orderBy('name');
    }
}

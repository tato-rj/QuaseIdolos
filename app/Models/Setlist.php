<?php

namespace App\Models;

class Setlist extends BaseModel
{
    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function scopeForShow($query, Show $show = null)
    {
        return $query->where('show_id', $show ? $show->id : null);
    }

    public function scopeForSong($query, Song $song = null)
    {
        return $query->where('song_id', $song ? $song->id : null);
    }

    public function scopeToggle($query, Show $show, Song $song)
    {
        if ($record = $query->forShow($show)->forSong($song)->first()) {
            $record->delete();
        } else {
            $this->create([
                'song_id' => $song->id,
                'show_id' => $show->id,
                'order' => $show->setlist()->count()
            ]);
        }
    }

    public function scopeReorder($query)
    {
        return $query->get()->each(function($record, $index) {
            $record->update(['order' => $index]);
        });
    }

    public function getOrderForHumansAttribute()
    {
        return $this->order + 1;
    }
}

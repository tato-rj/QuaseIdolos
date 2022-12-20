<?php

namespace App\Models;

class SongRequest extends BaseModel
{
    protected $dates = ['finished_at'];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function winners()
    {
        return $this->hasMany(Gig::class, 'winner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function position($complete = false)
    {
        $suffix = $complete ? ' da fila' : null;

        if ($this->order == 0)
            return $complete ? 'É a sua vez!' : fa('microphone-alt');

        return '#' . $this->order . $suffix;
    }

    public function scopeFrom($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeForGig($query, Gig $gig = null)
    {
        return $query->where('gig_id', $gig ? $gig->id : null);
    }

    public function scopeForSong($query, Song $song = null)
    {
        return $query->where('song_id', $song ? $song->id : null);
    }

    public function scopeForGigTonight($query, Gig $gig)
    {
        return $query->where('gig_id', $gig->id)
                     ->where('created_at', '>=', $gig->starts_at);
    }

    public function scopeWaiting($query)
    {
        return $query->whereNull('finished_at')->orderBy('order');
    }

    public function scopeRateable($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('has_ratings', true)->whereDoesntHave('admin');
        });
    }

    public function getDateForHumansAttribute()
    {
        $weekday = weekday($this->created_at->dayOfWeek);
        $month = month($this->created_at->month);

        return $weekday . ', ' . $this->created_at->day . ' de ' . $month;
    }

    public function score($round = false)
    {
        if (! $this->gig->ratings()->exists())
            return 0;

        $average = $this->ratings->avg('score');

        $weight = $this->ratings->count() * 5 / $this->gig->ratings->groupBy('user_id')->count();

        $weightedAverage = ($average + $weight) / 2;

        return $round ? round($weightedAverage) : $weightedAverage;
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('finished_at');
    }

    public function scopeWaitingFor($query, Song $song)
    {
        return $query->waiting()->where([
            ['song_id', $song->id],
            ['user_id', auth()->user()->id]
        ]);
    }

    public function wasRequestedBy(User $user)
    {
        return $this->user_id == $user->id;
    }
    
    public function add(User $user, Song $song, Gig $gig)
    {
        return $this->create([
            'user_id' => $user->id, 
            'song_id' => $song->id,
            'gig_id' => $gig->id,
            'order' => $this->waiting()->count()]);
    }

    public function finish()
    {
        if ($this->user->isAdmin())
            return $this->delete();

        return $this->update(['finished_at' => now()]);
    }

    public function isOver()
    {
        return (bool) $this->finished_at;
    }
}

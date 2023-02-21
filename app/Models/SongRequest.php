<?php

namespace App\Models;

class SongRequest extends BaseModel
{
    protected $dates = ['finished_at'];

    protected static function booted()
    {
        self::deleting(function(SongRequest $songRequest) {
            $songRequest->invitations->each->delete();
        });
    }

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function artist()
    {
        return $this->belongsToThrough(Artist::class, Song::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function winners()
    {
        return $this->hasMany(Gig::class, 'winner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function singers()
    {
        $singers = collect();

        $this->user->confirmed_at = now();

        $singers->push($this->user);

        foreach ($this->invitations as $invitation) {
            $invitation->user->confirmed_at = $invitation->confirmed_at;

            $singers->push($invitation->user);
        }

        return $singers;
    }

    public function singersNames($excludeMe = false)
    {
        $singers = $this->singers();

        if ($excludeMe)
            $singers = $singers->filter(function($singer) {
                return ! $singer->is(auth()->user());
            });

        $names = $singers->pluck('first_name');

        if ($this->hasCustomUsername()) {
            $names->shift();
            $names->prepend($this->user_name);
        }

        return $names;
    }

    public function hasCustomUsername()
    {
        return (bool) $this->user_name;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function inviteMany($ids = [])
    {
        foreach ($ids as $id) {
            if ($user = User::find($id))
                $this->invite($user);
        }
    }

    public function invite(User $user)
    {
        return Invitation::firstOrcreate([
            'song_request_id' => $this->id,
            'user_id' => $user->id]);
    }

    public function decline(User $user)
    {
        Invitation::where([
            'song_request_id' => $this->id,
            'user_id' => $user->id])->delete();
    }

    public function invited(User $user)
    {
        return $this->invitations()->to($user)->exists();
    }

    // public function position($complete = false)
    // {
    //     $suffix = $complete ? ' da fila' : null;

    //     if ($this->order == 0)
    //         return $complete ? 'É a sua vez!' : fa('microphone-alt');

    //     return '#' . $this->order . $suffix;
    // }

    public function scopeExcludeInvitations($query)
    {
        return $query->whereDoesntHave('invitations');
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

    public function scopeByGuests($query)
    {
        return $query->whereHas('user', function($q) {
            $q->doesntHave('admin');
        });
    }

    public function wasRequestedBy(User $user)
    {
        return $this->user_id == $user->id;
    }
    
    public function add(User $user, Song $song, Gig $gig, $name = null)
    {
        return $this->create([
            'user_name' => $name,
            'user_id' => $user->id, 
            'song_id' => $song->id,
            'gig_id' => $gig->id,
            'order' => $gig->setlist()->waiting()->count()]);
    }

    public function finish()
    {
        if (! $this->user || $this->user->admin()->exists())
            return $this->delete();

        return $this->update(['finished_at' => now()]);
    }

    public function isOver()
    {
        return (bool) $this->finished_at;
    }

    public function scopeRankingBetween($query, $from, $to)
    {
        return $query->selectRaw('created_at')
                     ->whereRaw('created_at BETWEEN '.carbon(datePtToUs($from))->toDateTimeString().' AND '.carbon(datePtToUs($to))->toDateTimeString())
                     // ->groupBy('song_id')
                     // ->orderByRaw('min(created_at) asc')
                     ->get();
    }
    // public function scopeRecords($query, $length)
    // {
    //     return $query->selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
    //         ->whereRaw('created_at >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL '.$length.')), INTERVAL 1 DAY) and created_at <= NOW()')
    //         ->groupBy('year', 'month')
    //         ->orderByRaw('min(created_at) asc')
    //         ->get();
    // }
}

<?php

namespace App\Models;

use App\Models\Traits\ReadableDates;

class SongRequest extends BaseModel
{
    use ReadableDates;
    
    protected $dates = ['finished_at'];
    protected $casts = ['was_recommended' => 'boolean'];

    protected static function booted()
    {
        self::deleting(function(SongRequest $songRequest) {
            $songRequest->invitations()->delete();
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
        if (! $ids)
            return;

        User::whereIn('id', $ids)->get()->each(function ($user) {
            $this->invite($user);
        });
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

    public function scopeBetweenDates($query, $from, $to)
    {
        if ($from)
            $query->where('song_requests.created_at', '>=', carbon($from)->startOfDay());

        if ($to)
            $query->where('song_requests.created_at', '<=', carbon($to)->endOfDay());

        return $query;
    }

    public function scopeGetRankingBy($query, $column, $count = 10)
    {
        // Aggregate history in SQL; hydrate only the top entities needed to render.
        switch ($column) {
            case 'song.artist_id':
                $model = new Artist;
                $query->join('songs', 'songs.id', '=', 'song_requests.song_id')
                    ->join('artists', 'artists.id', '=', 'songs.artist_id');
                break;
            case 'song.genre_id':
                $model = new Genre;
                $query->join('songs', 'songs.id', '=', 'song_requests.song_id')
                    ->join('genres', 'genres.id', '=', 'songs.genre_id');
                break;
            case 'song_id':
                $model = new Song;
                $query->join('songs', 'songs.id', '=', 'song_requests.song_id')
                    ->join('artists', 'artists.id', '=', 'songs.artist_id');
                break;
            case 'user_id':
                $model = new User;
                $query->join('users', 'users.id', '=', 'song_requests.user_id');
                break;
            default:
                throw new \InvalidArgumentException('Unsupported statistics ranking.');
        }

        $ranking = $query->select($model->getQualifiedKeyName().' as ranking_id')
            ->selectRaw('COUNT(*) as request_count, MIN(song_requests.id) as first_request_id')
            ->groupBy($model->getQualifiedKeyName())->reorder()
            ->orderByDesc('request_count')->orderBy('first_request_id')->limit($count)
            ->toBase()->get();

        $entities = $model->newQuery()->select($model->getTable().'.*')
            ->whereIn($model->getKeyName(), $ranking->pluck('ranking_id'));

        if ($model instanceof Song)
            $entities->with(['artist' => function ($query) { $query->select('artists.*'); }]);

        $entities = $entities->get()->keyBy($model->getKeyName());

        return $ranking->map(function ($entry) use ($entities) {
            $entity = $entities->get($entry->ranking_id);

            return $entity ? $entity->setAttribute('request_count', (int) $entry->request_count) : null;
        })->filter()->values();
    }

    public function wasRequestedBy(User $user)
    {
        return $this->user_id == $user->id;
    }
    
    public function add(User $user, Song $song, Gig $gig, $name = null)
    {
        $songRequest = $this->create([
            'user_name' => $name,
            'user_id' => $user->id, 
            'song_id' => $song->id,
            'gig_id' => $gig->id,
            'order' => ($gig->setlist()->waiting()->reorder()->max('order') ?? -1) + 1]);

        if ($set = $gig->sets()->first())
            $set->incrementQueue();

        return $songRequest->setRelation('gig', $gig)->setRelation('song', $song)->setRelation('user', $user);
    }

    public function finish()
    {
        if ($this->isOver())
            return $this;

        if (! $this->user) {
            $this->delete();
        } else {
            $this->update(['finished_at' => now()]);
        }

        if ($set = $this->gig->sets()->first())
            $set->decrementQueue();

        return $this;
    }

    public function cancel()
    {
        $this->delete();

        if ($set = $this->gig->sets()->first())
            $set->decrementQueue();
    }

    public function isOver()
    {
        return (bool) $this->finished_at;
    }
}

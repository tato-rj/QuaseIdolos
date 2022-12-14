<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\{Searchable, Rateable, Locateable, Archiveable, HasAvatar};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, Rateable, Locateable, Archiveable, HasAvatar;

    protected $appends = ['is_admin'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'boolean' => 'participate_in_ratings'
    ];

    public function favorites()
    {
        return $this->belongsToMany(Song::class, 'favorites', 'user_id', 'song_id')
                    ->with(['artist'])
                    ->withTimestamps()
                    ->orderBy('favorites.created_at', 'DESC');
    }

    public function songRequests()
    {
        return $this->hasMany(SongRequest::class)->with(['song', 'user']);
    }

    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }

    public function ratings()
    {
        return $this->hasManyThrough(Rating::class, SongRequest::class);
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class);
    }

    public function rate(SongRequest $songRequest, $score)
    {
        $attempt = Rating::from($this)->for($songRequest);
    
        if ($attempt->exists() && $attempt->first()->tooManyAttempts())
            abort(429, 'Você não pode mais mudar esse voto'); 

        $rating = Rating::updateOrCreate([
            'user_id' => $this->id,
            'song_request_id' => $songRequest->id
        ], ['score' => $score]);

        $rating->increment('attempts');

        return $rating;
    }

    public function ratingFor(SongRequest $songRequest)
    {
        $rating = $this->ratingsGiven()->where('song_request_id', $songRequest->id)->first();

        return $rating ? $rating->score : null;
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function gig()
    {
        return $this->belongsToMany(Gig::class, 'participants');
    }

    public function checkLiveGig()
    {
        $this->liveGig = $this->gig()->live()->first();
    }

    // public function liveGig()
    // {
    //     return $this->gig()->live()->first();
    // }

    public function liveGigExists()
    {
        return $this->liveGig;
    }

    public function join(Gig $gig)
    {
        Participant::by($this)->unconfirmed()->delete();
        $this->songRequests()->waiting()->delete();
        
        $this->gig()->save($gig);

        $this->checkLiveGig();

        return $this->liveGig;
    }

    public function joined(Gig $gig)
    {
        return $this->liveGig && $this->liveGig->is($gig);
    }

    public function tryToJoin($gigs)
    {
        if ($this->gig()->live()->exists())
            return null;

        if ($gigs->count() == 1 && $gigs->first()->isLive()){
            if (! $gigs->first()->password()->required()) {
                $this->join($gigs->first());
                return 'pages.gigs.welcome.modal';
            } else {
                return 'pages.gigs.modals.password';
            }
        }
    }

    public function scopeTeam($query)
    {
        $userId = auth()->check() ? auth()->user()->id : null;

        return $query->has('admin')->where('id', '!=', $userId);
    }

    public function scopeGuests($query)
    {
        return $query->doesntHave('admin');
    }

    public function scopeRanking($query)
    {
        return $query->has('ratings')->withAvg('ratings', 'score')->orderBy('ratings_avg_score', 'desc');
    }

    public function getInitialAttribute()
    {
        return $this->name[0];
    }

    public function isRateable()
    {
        return $this->participate_in_ratings;
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function isAdmin()
    {
        return (bool) $this->admin;
    }

    public function requestedTonight(Song $song)
    {
        $gig = testing() ? $this->gig()->live()->first() : $this->liveGig;
        
        return $this->songRequests()
                    ->forGig($gig)
                    ->where('created_at', '>=', now()->subHours(12))
                    ->where('song_id', $song->id)->exists();
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function isSuperAdmin()
    {
        return $this->isAdmin() && (bool) $this->admin->super_admin;
    }

    public function favorited(Song $song)
    {
        return $this->favorites()->where(['song_id' => $song->id])->exists();
    }

    public function sung(Song $song)
    {
        return $this->songRequests()->whereNotNull('finished_at')->where(['song_id' => $song->id])->exists();
    }

    public function requestsSung()
    {
        return $this->songRequests()->whereNotNull('finished_at')->orderBy('finished_at', 'DESC');
    }

    public function requestsWaiting()
    {
        return $this->songRequests->whereNull('finished_at');
    }

    public function hasAvatar()
    {
        return (bool) $this->avatar_url;
    }

    public function hasOwnAvatar()
    {
        return $this->hasAvatar() && ! \Str::contains($this->avatar_url, 'http');
    }

    public function avatar()
    {
        if ($this->hasOwnAvatar())
            return $this->coverImage('avatar_url');

        return $this->avatar_url;
    }
}

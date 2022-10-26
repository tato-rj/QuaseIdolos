<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    protected static function booted()
    {
        self::deleting(function($user) {
            $user->favorites->each->delete();
        });
    }

    public function getInitialAttribute()
    {
        return $this->name[0];
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function favorites()
    {
        return $this->belongsToMany(Song::class, 'favorites', 'user_id', 'song_id')
                    ->with(['artist'])
                    ->withTimestamps()
                    ->orderBy('favorites.created_at', 'DESC');
    }

    public function setlists()
    {
        return $this->hasMany(Setlist::class)->with(['song', 'user']);
    }

    public function scopeGuests($query)
    {
        return $query->where('is_admin', false);
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public function favorited(Song $song)
    {
        return $this->favorites()->where(['song_id' => $song->id]);
    }

    public function completed(Song $song)
    {
        return $this->setlists()->whereNotNull('finished_at')->where(['song_id' => $song->id]);
    }

    public function alreadySung()
    {
        return $this->setlists()->whereNotNull('finished_at')->orderBy('finished_at', 'DESC')->get();
    }

    public function waitingFor()
    {
        return $this->setlists->whereNull('finished_at');
    }

    public function hasAvatar()
    {
        return (bool) $this->avatar_url;
    }
}

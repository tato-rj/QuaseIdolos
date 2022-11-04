<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    protected $appends = ['is_admin'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
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

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function scopeTeam($query)
    {
        return $query->has('admin')->where('id', '!=', auth()->user()->id);
    }

    public function scopeGuests($query)
    {
        return $query->doesntHave('admin');
    }

    public function getInitialAttribute()
    {
        return $this->name[0];
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function isAdmin()
    {
        return $this->admin()->exists();
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
        return $this->songRequests()->whereNotNull('finished_at')->orderBy('finished_at', 'DESC')->get();
    }

    public function requestsWaiting()
    {
        return $this->songRequests->whereNull('finished_at');
    }

    public function hasAvatar()
    {
        return (bool) $this->avatar_url;
    }
}

<?php

namespace App\Models;

class Invitation extends BaseModel
{
    protected $with = ['songRequest'];
    protected $giphys = ['rVVFWyTINqG7C', 'oYtVHSxngR3lC', 'aWPGuTlDqq2yc', '5p2wQFyu8GsFO', 'xuuENXQExEY6Nsb1TD', 'weH6gwEsVTe7aFDchk', '7FE5w6ycpb3sqr8OrX', 'U5a3PgTauBbmsGSVdc', 'n3eFl3NI07pQ93dGEx', 'CgFfkHEn5E8BHKuwqf', 'nkiDXkm5D5JCvfGwy3', '0AA2LiChVmvxt8v1HB', 'iGutriLEHAjir7FK3p', 'l0He0cVv8lGggpruo', 'B8CHqQLm4dXMUNmz0z', '6uOKby3tWy4yXwTa5H', 'xKy2w6LehxxHa'];

    public function user()
    {
        return $this->belongsTo(User::class);   
    }

    public function songRequest()
    {
        return $this->belongsTo(SongRequest::class);
    }

    public function scopeForGig($query, Gig $gig = null)
    {
        return $query->whereHas('songRequest', function($q) use ($gig) {
            $q->where('gig_id', $gig ? $gig->id : null);
        });
    }

    public function scopeWaiting($query)
    {
        return $query->whereHas('songRequest', function($q) {
            $q->whereNull('finished_at')->orderBy('order');
        });
    }

    public function giphy()
    {
        return 'https://media.giphy.com/media/'.randval($this->giphys).'/giphy.gif';
    }

    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('confirmed_at');
    }

    public function scopeUnconfirmed($query)
    {
        return $query->whereNull('confirmed_at');
    }

    public function scopeFromMe($query)
    {
        return $query->whereHas('songRequest', function($q) {
            $q->where('user_id', auth()->user()->id);
        });
    }

    public function scopeTo($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeToMe($query)
    {
        return $query->to(auth()->user());
    }

    public function confirmed()
    {
        return (bool) $this->confirmed_at;
    }

    public function confirm()
    {
        return $this->update(['confirmed_at' => now()]);
    }
}

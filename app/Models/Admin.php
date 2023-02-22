<?php

namespace App\Models;

class Admin extends BaseModel
{
    protected $casts = [
        'manage_events' => 'boolean',
        'manage_setlist' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuperAdmin($query)
    {
        return $query->where('manage_events', true)->where('manage_setlist', true);
    }

    public function scopeMusicians($query)
    {
        return $query->whereNotNull('instruments');
    }

    public function getInstrumentsAttribute($instruments)
    {
        if (is_null($instruments))
            return [];

        return json_decode($instruments);
    }

    public function isSuperAdmin()
    {
        return $this->manage_events && $this->manage_setlist;
    }

    public function isMusician()
    {
        return (bool) $this->instruments;
    }

    public function isSub()
    {
        return ! $this->manage_events && ! $this->manage_setlist;
    }

    public function icon()
    {
        if ($this->isSuperAdmin())
            return fa('chess-king', 'yellow');

        if (! $this->manage_events && $this->manage_setlist)
            return fa('guitar', 'orange');
    }
}

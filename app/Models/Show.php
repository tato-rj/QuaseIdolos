<?php

namespace App\Models;

class Show extends EventModel
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}

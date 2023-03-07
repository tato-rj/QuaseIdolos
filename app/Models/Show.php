<?php

namespace App\Models;

class Show extends BaseModel
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

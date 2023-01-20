<?php

namespace App\Models;

class Favorite extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

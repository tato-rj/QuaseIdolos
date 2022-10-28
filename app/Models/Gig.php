<?php

namespace App\Models;

class Gig extends BaseModel
{
	public function scopeLive($query)
	{
		return $query->where('user_id', 1);
	}
}

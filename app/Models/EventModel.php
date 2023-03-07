<?php

namespace App\Models;

abstract class EventModel extends BaseModel
{
	public function creator()
	{
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function venue()
	{
		return $this->belongsTo(Venue::class);
	}

    public function name()
    {
    	return $this->name ?? $this->venue->name;
    }
        
    public function description()
    {
    	return $this->description ?? $this->venue->description;
    }
}
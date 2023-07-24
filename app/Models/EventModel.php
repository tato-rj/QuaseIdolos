<?php

namespace App\Models;

use App\Models\Traits\ReadableDates;

abstract class EventModel extends BaseModel
{
	use ReadableDates;

	protected $dates = ['starts_at', 'ends_at', 'scheduled_for', 'scheduled_end_at'];

	abstract function scopeReady($query);
	abstract function isKareoke();
	abstract function isShow();
	abstract function status();
	abstract function close();
	abstract function openRoute();
	abstract function closeRoute();

	public function getVenueNameAttribute()
	{
		return $this->venue->name;
	}

    public function scopeNotReady($query)
    {
		return $query->except($this->ready()->get('id'));
    }

    public function sandbox()
    {
    	return $this->is_test;
    }

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

	public function getFullNameAttribute()
	{
		return $this->name;
	}

    public function scopeIn($query, Venue $venue)
    {
    	return $query->where('venue_id', $venue->id);
    }
    
	public function scopeByEventDate($query)
	{
		return $query->orderBy('scheduled_for', 'desc');
	}

	public function scopeUnscheduled($query)
	{
		return $query->whereNull('scheduled_for');
	}

	public function scopeScheduled($query)
	{
		return $query->whereNotNull('scheduled_for');
	}

	public function scopeNotLive($query)
	{
		return $query->where('is_live', false);
	}

	public function scopeLive($query)
	{
		return $query->where('is_live', true);
	}

	public function scopeOrLive($query)
	{
		return $query->orWhere('is_live', true);
	}

    public function scopeUpcoming($query)
    {
    	return $query->where('scheduled_for', '>=', now()->startOfDay());
    }

    public function scopePast($query)
    {
    	return $query->where('scheduled_for', '<', now()->startOfDay());
    }

    public function scopeOrPast($query)
    {
    	return $query->orWhere('scheduled_for', '<', now()->startOfDay());
    }

	public function getDateForHumansAttribute()
	{
		return $this->dateForHumans();
	}
	
	public function dateInContext()
	{
		if ($this->isUnscheduled())
			return null;

		if ($this->scheduled_for->isToday())
			return 'Hoje';

		if ($this->scheduled_for->isYesterday())
			return 'Ontem';

		if ($this->scheduled_for->isTomorrow())
			return 'Amanhã';

		return $this->dateForHumans;
	}
	
    public function open()
    {
        return $this->update([
            'is_live' => true,
            'starts_at' => now(),
        ]);
    }

    public function endingTime()
    {
    	if ($this->duration && $this->hasStarted())
    		return local() ? $this->starts_at->copy()->addMinutes($this->duration) : $this->starts_at->copy()->addHours($this->duration);
    }
}
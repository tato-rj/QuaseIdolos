<?php

namespace App\Models\Traits;

trait GigStates
{
	public function isToday()
	{
		return $this->isUnscheduled() ? false : $this->scheduled_for->isSameDay(now());
	}

	public function isPrivate()
	{
		return (bool) $this->is_private;
	}

	public function isPaused()
	{
		return $this->is_paused;
	}

	public function isLive()
	{
		return $this->is_live;
	}

	public function isOff()
	{
		return $this->isReady() && $this->isOver();
	}

	public function isFull()
	{
		return is_null($this->songs_limit) ? false : $this->setlist->count() == $this->songs_limit;
	}

	public function isOver()
	{
		return (bool) $this->ends_at;
	}

	public function isPast()
	{
		return ! $this->isReady() && $this->scheduled_for->lt(now());
	}

	public function isUnscheduled()
	{
		return (bool) ! $this->scheduled_for;
	}

	public function isReady()
	{
		if ($this->isUnscheduled())
			return false;

		return now()->gte($this->scheduled_for) && now()->lt($this->scheduled_for->addDay()->addHours(4));
	}

	public function isLater()
	{
		return $this->scheduled_for->gt(now());
	}
}
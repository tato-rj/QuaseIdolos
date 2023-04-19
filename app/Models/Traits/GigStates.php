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
		return is_null($this->songs_limit) ? false : $this->setlist()->byGuests()->count() >= $this->songs_limit;
	}

	public function setIsFull()
	{
		return $this->set_is_full;
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

	public function hasStarted()
	{
		return (bool) $this->starts_at;
	}

	public function shouldFinish()
	{
		$endtime = $this->endingTime();

		return $endtime ? $endtime->lte(now()) : false;
	}

	public function feedback()
	{
		if (! $this->isKareoke())
			return null;

		if ($this->isFull())
			return '<span class="text-red">Inscrições encerradas, muito obrigado!</span>';

		if ($this->isPaused())
			return '<span class="text-red">Voltamos daqui a alguns instantes</span>';
		
		if ($this->setIsFull()) {
			$waitingCount = $this->setlist()->waiting()->count();

			return '<span class="text-secondary">As inscrições voltam  daqui a ' . $waitingCount . ' ' . str_plural('música', $waitingCount) . '</span>';
		}

		if ($this->userLimitReached())
			return '<span class="text-red">O seu limite de músicas foi alcançado</span>';

		return '<span class="text-green">Incrições abertas, esperamos você!</span>';
	}
}
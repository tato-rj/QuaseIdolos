<?php

namespace App\Tools\Gig;

class Status extends StatusFactory
{
	protected $states = [
		'unscheduled',
		'paused',
		'live',
		'off',
		'over',
		'ready',
		'past',
		'later'
	];

	public function whenUnscheduled()
	{
		return $this->create(fa('circle', 'grey', 'mr-2'), 'Sem data');
	}

	public function whenPaused()
	{
		return $this->create(fa('circle', 'yellow', 'mr-2'), 'Pausado');
	}

	public function whenLive()
	{
		return $this->create(fa('circle', 'green', 'mr-2'), 'Ao vivo!');
	}

	public function whenOff()
	{
		return $this->create(fa('circle', 'red', 'mr-2'), 'Fechado');
	}

	public function whenOver()
	{
		return $this->create(fa('calendar-day', 'transparent', 'mr-2'), 'Terminou ' .$this->gig->ends_at->diffForHumans());
	}

	public function whenReady()
	{
		return $this->create(fa('circle', 'yellow', 'mr-2'), 'Esperando pra começar');
	}

	public function whenPast()
	{
		return $this->create(fa('hourglass-half', 'white', 'mr-2'), 'Começou ' .$this->gig->scheduled_for->diffForHumans());
	}

	public function whenLater()
	{
		return $this->create(fa('hourglass-half', 'yellow', 'mr-2'), 'Começa ' .$this->gig->scheduled_for->diffForHumans());
	}
}
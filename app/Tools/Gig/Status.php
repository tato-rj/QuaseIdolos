<?php

namespace App\Tools\Gig;

class Status extends StatusFactory
{
	protected $states = [
		'unscheduled',
		'paused',
		'live',
		'over',
		'past',
		'later',
		'ready',
		'off',
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
		$icon = $this->gig->isReady() ? fa('circle', 'yellow', 'mr-2') : fa('calendar-day', 'transparent', 'mr-2');

		return $this->create($icon, 'Terminou ' .$this->gig->ends_at->diffForHumans());
	}

	public function whenReady()
	{
		$text = $this->gig->isOver() ? 'Terminou ' .$this->gig->ends_at->diffForHumans() : 'Esperando pra começar';

		return $this->create(fa('circle', 'yellow', 'mr-2'), $text);
	}

	public function whenPast()
	{
		$icon = $this->gig->isReady() ? fa('circle', 'yellow', 'mr-2') : fa('hourglass-half', 'white', 'mr-2');

		return $this->create($icon, 'Começou ' .$this->gig->scheduled_for->diffForHumans());
	}

	public function whenLater()
	{
		return $this->create(fa('hourglass-half', 'yellow', 'mr-2'), 'Começa ' .$this->gig->scheduled_for->diffForHumans());
	}
}
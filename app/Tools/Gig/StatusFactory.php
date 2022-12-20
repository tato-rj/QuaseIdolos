<?php

namespace App\Tools\Gig;

use App\Models\Gig;

abstract class StatusFactory
{
	protected $gig, $withText;

	public function __construct(Gig $gig)
	{
		$this->gig = $gig;
	}

	public function withText($withText = true)
	{
		$this->withText = $withText;

		return $this;
	}

	public function get()
	{
		if ($state = $this->checkStates())
			return $state;
	}

	public function create($icon, $text)
	{
		return $this->withText ? $icon . $text : $icon;
	}

	public function checkStates()
	{
		foreach ($this->states as $state) {
			if ($this->gig->{'is'.ucfirst($state)}())
				return $this->{'when'.ucfirst($state)}();
		}
	}
}
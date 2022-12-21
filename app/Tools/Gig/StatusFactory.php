<?php

namespace App\Tools\Gig;

use App\Models\Gig;

abstract class StatusFactory
{
	protected $gig, $withText, $onlyText;

	public function __construct(Gig $gig)
	{
		$this->gig = $gig;
		$this->withText = true;
	}

	public function onlyText()
	{
		$this->onlyText = true;

		return $this;
	}

	public function noText()
	{
		$this->withText = false;

		return $this;
	}

	public function get()
	{
		if ($state = $this->checkStates())
			return $state;
	}

	public function create($icon, $text)
	{
		if ($this->onlyText)
			return $text;
		
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
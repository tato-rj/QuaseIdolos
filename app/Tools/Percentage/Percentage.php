<?php

namespace App\Tools\Percentage;

class Percentage
{
	protected $percentage;

	public function __construct($percentage = null)
	{
		$this->percentage = floatval($percentage);
	}

	public function of($num)
	{
		if (! $this->percentage)
			return null;

		return floatval($num) * $this->percentage / 100;
	}
}
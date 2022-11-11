<?php

namespace App\Models\Traits;

trait Rateable
{
	public function participatesInRatings()
	{
		return (bool) $this->has_ratings;
	}
}
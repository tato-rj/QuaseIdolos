<?php

namespace App\Models\Traits;

use App\Models\Gig;

trait Locateable
{
	protected $radius = 1000;
	
	public function coordinates()
	{
		$location = geoip()->getLocation(request()->ip());

		$coordinates = collect();
		$coordinates->lat = $location->lat;
		$coordinates->lon = $location->lon;
		
		return $coordinates;
	}

	public function isLikelyInside(Gig $gig)
	{
		return $this->distanceTo($gig) < $this->radius;
	}

	function distanceTo(Gig $gig, $earthRadius = 6371000)
	{
		$coordinates = $this->coordinates();

		$latFrom = deg2rad($coordinates->lat);
		$lonFrom = deg2rad($coordinates->lon);
		$latTo = deg2rad($gig->lat);
		$lonTo = deg2rad($gig->lon);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}
}
<?php

namespace App\Archives\Models;

use App\Models\Gig;
use App\Archives\ArchivesFactory;

class UserArchives extends ArchivesFactory
{
	public function saveGig(Gig $gig)
	{
		$this->set('gigs', $gig);
	}

	public function saveSongRequests(Gig $gig)
	{
		foreach($this->model->songRequests()->forGig($gig)->completed()->get() as $songRequest) {
			$this->set('songRequests', $songRequest);
		}
	}

	public function saveRatings(Gig $gig)
	{
		foreach($gig->ratings()->to($this->model)->get() as $rating) {
			$this->set('ratings', $rating);
		}
	}
}
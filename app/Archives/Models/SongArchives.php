<?php

namespace App\Archives\Models;

use App\Models\{SongRequest, Rating};
use App\Archives\ArchivesFactory;

class SongArchives extends ArchivesFactory
{
	public function saveSongRequest(SongRequest $songRequest)
	{
        $this->set('songRequests', $songRequest);
	}

	public function saveRating(Rating $rating)
	{
        $this->set('ratings', $rating);
	}
}

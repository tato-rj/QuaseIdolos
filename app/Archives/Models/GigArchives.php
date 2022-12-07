<?php

namespace App\Archives\Models;

use App\Models\Gig;
use App\Archives\ArchivesFactory;

class GigArchives extends ArchivesFactory
{
	public function save()
	{
		$gig = $this->model;
		
        $this->saveParticipants();
        $this->saveSetlist();
        $this->saveRatings();
        $this->saveWinner();

        $this->model->participants->each(function($user) use ($gig) {
            $user->archives()->saveGig($gig);
            $user->archives()->saveSongRequests($gig);
            $user->archives()->saveRatings($gig);
        });	

        $this->model->setlist()->completed()->get()->groupBy('song_request_id')->each(function($group) use ($gig) {
        	$group->each(function($songRequest) {
        		$songRequest->song->archives()->saveSongRequest($songRequest);
        	});
        });

        $this->model->ratings->groupBy('song_request_id')->each(function($group) {
        	$group->each(function($rating) {
        		$rating->songRequest->song->archives()->saveRating($rating);
        	});
        });
	}

	public function saveParticipants()
	{
		foreach($this->model->participants as $participant) {
			$this->set('participants', $participant);
		}
	}

	public function saveSetlist()
	{
		foreach($this->model->setlist()->completed()->get() as $songRequest) {
			$this->set('setlist', $songRequest);
		}
	}

	public function saveRatings()
	{
		foreach($this->model->ratings as $rating) {
			$this->set('ratings', $rating);
		}
	}

	public function saveWinner()
	{
		$this->set('winner', $this->model->winner);
	}
}

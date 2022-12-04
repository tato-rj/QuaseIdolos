<?php

namespace App\Archives;

use App\Models\Gig;
use Illuminate\Support\Facades\Redis;

class GigArchives
{
	protected $gig;

	public function __construct(Gig $gig)
	{
		$this->gig = $gig;
	}

	public function saveParticipants()
	{
		foreach($this->gig->participants as $participant) {
			$record = [
				'name' => $participant->name, 
				'email' => $participant->email, 
				'created_at' => $participant->created_at
			];
			// $record = collect();
			// $record->name = $participant->name;
			// $record->email = $participant->email;
			// $record->created_at = $participant->created_at;

			Redis::sadd('gig:'.$this->gig->id.':participants', $record);
		}
	}

	public function getParticipants()
	{
		return Redis::smembers('gig:'.$this->gig->id.':participants');
	}

	public function getSongRequests()
	{
		return collect();
	}
}
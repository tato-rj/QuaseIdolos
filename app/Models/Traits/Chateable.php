<?php

namespace App\Models\Traits;

trait Chateable
{
	public function participatesInChats()
	{
		return (bool) $this->participates_in_chat;
	}
}
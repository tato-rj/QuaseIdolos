<?php

namespace App\Voting;

use App\Models\Gig;

class Rules
{
	protected $gig, $global;
	protected $globalRules = ['Proibido subir com bebida no palco'];

	public function __construct(Gig $gig)
	{
		$this->gig = $gig;
	}

	public function isGlobal($bool)
	{
		$this->global = $bool;

		return $this;
	}

	public function create()
	{
    	if ($this->global)
    		return collect($this->globalRules);
    	
    	$voting = $this->gig->participatesInRatings() ? 
    		'Este evento está aberto pra votação' : 
    		'Este evento não está aberto pra votação';
		
		$userLimit = $this->gig->songs_limit_per_user ? 'Limite de '.$this->gig->songs_limit_per_user. ' ' . trans_choice('plurais.música', $this->gig->songs_limit_per_user) . ' por pessoa' : null;

		$songsLimit = $this->gig->songs_limit ? 'Limite total de '.$this->gig->songs_limit. ' ' . trans_choice('plurais.música', $this->gig->songs_limit) : null;

		$repetitionUser = 'Ninguém pode cantar a mesma música mais de uma vez';

		if ($this->gig->repeat_limit == 0) {
			$repetitionLimit = 'Uma música não pode ser escolhida mais de uma vez no programa';
		} else if ($this->gig->repeat_limit == 1) {
			$repetitionLimit = 'Uma música só pode ser repetida até 1 vez no programa';
		} else {
			$repetitionLimit = 'Uma música só pode ser repetida até '.$this->gig->repeat_limit.' vezes no programa';
		}

		return collect([
			$voting, $userLimit, $songsLimit, $repetitionUser, $repetitionLimit
		]);
	}
}
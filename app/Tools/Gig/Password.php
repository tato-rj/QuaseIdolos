<?php

namespace App\Tools\Gig;

use App\Models\Gig;

class Password
{
	public function __construct(Gig $gig)
	{
		$this->gig = $gig;
	}

	public function generate($digits = 4)
	{
		return (string) rand(pow(10, $digits - 1), pow(10, $digits) - 1);
	}

    public function verify($password)
    {
    	return $password == $this->gig->password;
    }

    public function required()
    {
    	return (bool) $this->gig->password;
    }

    public function digits()
    {
    	return str_split($this->gig->password);
    }

    public function update($password = null)
    {
    	$this->gig->update(['password' => $password ?? $this->generate()]);
    }

    public function destroy()
    {
    	$this->gig->update(['password' => null]);
    }
}
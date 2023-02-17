<?php

namespace App\Tools\Mail;

use Illuminate\Mail\Mailable;

class SafeMail
{
	protected $email;

	public function to($email)
	{
		$this->email = $email;

		return $this;
	}

	public function send(Mailable $mail)
	{
		try {
			\Mail::to($this->email)->queue($mail);
		} catch (\Exception $e) {
			bugreport($e);
		}
	}
}
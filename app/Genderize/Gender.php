<?php

namespace App\Genderize;

class Gender
{
	protected $data;

	public function __construct($name)
	{
		try {
	        $data = file_get_contents('http://api.genderize.io?' . http_build_query(['name' => $name]));

	        $this->data = json_decode($data);	
		} catch (\Exception $e) {
			bugreport($e);
		}
	}

	public function guess()
	{
		if (! $this->data)
			return null;
		
		try {
			if ($this->data->probability >= 0.5) {
				return $this->data->gender;
			} else {
				return 'unknown';
			}
		} catch (\Exception $e) {
			bugreport($e);
		}
	}
}
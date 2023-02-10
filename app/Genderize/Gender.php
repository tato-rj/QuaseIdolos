<?php

namespace App\Genderize;

class Gender
{
	protected $data;

	public function __construct($name)
	{
        $data = file_get_contents('http://api.genderize.io?' . http_build_query(['name' => $name]));

        $this->data = json_decode($data);
	}

	public function guess()
	{
		try {
			// if ($this->data->probability > 0.75) {
				return $this->data->gender;
			// } else {
				// return 'unknown';
			// }
		} catch (\Exception $e) {
			bugreport($e);
		}
	}
}
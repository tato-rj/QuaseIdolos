<?php

namespace App\Status;

use App\Status\Traits\Relationships;

class AppStatus
{
	use Relationships;

	protected $model, $errors;

	public function __construct($model)
	{
		$this->errors = collect();
		$this->model = $model;
	}

	public function check()
	{
		return $this->errors;
	}

	public function guessField($model)
	{
		return strtolower(class_basename($model)) . '_id';
	}
}
<?php

namespace App\Archives;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

abstract class ArchivesFactory
{
	protected $model, $namespace;

	public function __construct(Model $model)
	{
		$this->model = $model;
		$this->namespace = strtolower(class_basename($this->model::class)).':'.$this->model->id.':';
	}

	public function get($field, $count = -1)
	{
		return Redis::lrange($this->namespace.$field, 0, $count);
	}

	public function set($field, $record)
	{
		$data = is_array($record) ? json_encode($record) : $record;
		return Redis::lpush($this->namespace.$field, $data);
	}
}
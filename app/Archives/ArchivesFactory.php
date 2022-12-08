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
		$id = $this->model->exists ? $this->model->id : '*';
		$this->namespace = strtolower(class_basename($this->model::class)).':'.$id.':';
	}

	public function get($field, $count = -1)
	{
		$records = collect(Redis::lrange($this->namespace.$field, 0, $count));

		return $records->map(function($record) {
			return json_decode($record);
		});
	}

	public function count($field, $count = -1)
	{
		return Redis::llen($this->namespace.$field);
	}

	public function set($field, $record)
	{
		$data = is_array($record) ? json_encode($record) : $record;
		return Redis::lpush($this->namespace.$field, $data);
	}
}
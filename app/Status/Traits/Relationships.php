<?php

namespace App\Status\Traits;

trait Relationships
{
	public function hasMany(array $relationships, $field = null)
	{
		$field = $field ?? $this->guessField($this->model);

		foreach ($relationships as $model) {
			foreach ($model::get(['id', $field]) as $record) {
				if (! $this->model::where('id', $record->$field)->exists())
					$this->errors->push(class_basename($model) . ':' . $record->id . ' is missing the ' . str_replace('_id', '', $field));
			}
		}

		return $this;
	}

	public function belongsTo(array $relationships, $field = null)
	{
		foreach ($relationships as $model) {
			$field = $field ?? $this->guessField($model);

			foreach ($this->model::all() as $record) {
				if (! $model::where('id', $record->$field)->exists())
					$this->errors->push(class_basename($record) . ':' . $record->id . ' is missing the ' . str_replace('_id', '', $field));
			}
		}

		return $this;
	}
}
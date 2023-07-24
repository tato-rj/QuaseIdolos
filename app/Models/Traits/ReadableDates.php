<?php

namespace App\Models\Traits;

trait ReadableDates 
{
	public function dateForHumans($showWeek = true, $column = 'scheduled_for')
	{
		$weekday = weekday($this->$column->dayOfWeek);
		$month = month($this->$column->month);

		if ($showWeek)
			return $weekday . ', ' . $this->$column->day . ' de ' . $month;

		return $this->$column->day . ' de ' . $month;
	}
}
<?php

namespace App\Tools\ChartJS;

class Chart extends ChartFactory
{
	public function monthly()
	{
		$this->build('year('.$this->column.') year, month('.$this->column.') month, count(*) count');

		$records = $this->query->groupBy('year', 'month')->get();

		$dates = $this->from()->toPeriod($this->to(), '1 month');

		$data = collect();

		foreach($dates as $date) {
			$record = $records->where('year', $date->year)->where('month', $date->month)->first();

			$data->push([
				'label' => monthname($record->month ?? $date->month),
				'count' => $record->count ?? 0,
			]);
		}

		return $data;
	}

	public function yearly()
	{
		$this->build('year('.$this->column.') year, count(*) count');

		$records = $this->query->groupBy('year')->get();

		$dates = $this->from()->toPeriod($this->to(), '1 year');

		$data = collect();

		foreach($dates as $date) {
			$record = $records->where('year', $date->year)->first();

			$data->push([
				'label' => $record->year ?? $date->year,
				'count' => $record->count ?? 0,
			]);
		}

		return $data;
	}
}
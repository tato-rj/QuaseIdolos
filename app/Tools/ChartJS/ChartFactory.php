<?php

namespace App\Tools\ChartJS;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class ChartFactory
{
	protected $query, $column, $interval;

	public function for($model)
	{
		$this->query = (new $model)->query();

		return $this;
	}

	public function date($column)
	{
		$this->column = $column;

		return $this;
	}

	public function between(Carbon $from, Carbon $to)
	{
		$this->interval = [$from->startOfDay(), $to->endOfDay()];
			 
		return $this;
	}

	public function from()
	{
		return $this->interval[0];
	}

	public function to()
	{
		return $this->interval[1];
	}

	public function groupBy($method)
	{
		$this->monthly = true;

		return $this;
	}

	public function build($arg)
	{
		$this->query
			 ->selectRaw($arg)
			 ->whereBetween($this->column, $this->interval);
	}

	public function get($method)
	{
        if (! method_exists($this, $method))
        	abort(404);

        return $this->$method();
	}
}
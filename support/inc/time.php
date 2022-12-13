<?php

function timeslots($first_hour = 8, $last_hour = 21, $frequency = 30)
{
	$origin = now()->copy();
	$date = now()->copy()->startOfDay();
	$slots = collect();

	$date->hour = $first_hour;

	while ($date->isSameDay($origin)) {
		if ($date->hour <= $last_hour)
			$slots->put($date->copy()->timestamp, $date->format('H:i'));
	
		$date->addMinutes($frequency);
	}

	return $slots;
}

function month($index)
{
	$array = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

	return $array[$index - 1];
}

function weekday($index)
{
	$array = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

	return $array[$index];
}

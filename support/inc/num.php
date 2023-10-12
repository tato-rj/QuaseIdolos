<?php

function percentage($num, $total, $cap = null)
{
	if ($total == 0)
		return 0;

	$percent = (int)round(($num * 100) / $total);

	if ($cap)
		return $percent > $cap ? $cap : $percent;

	return $percent;
}

function randomFromArray($array = [])
{
	return $array[array_rand($array)];
}
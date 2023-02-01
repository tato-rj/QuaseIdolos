<?php

function showtags($str)
{
	return htmlspecialchars($str);
}

function plural($word, $count)
{
	return \Str::plural($word, $count);
}

function uuid()
{
	return (string) \Str::uuid();
}

function simpleUrl($url)
{
	return explode("?", $url)[0];
}

function datePtToUs($string)
{
	$pieces = explode('/', $string);

	if (count($pieces) == 3)
		return $pieces[1].'/'.$pieces[0].'/'.$pieces[2];
}

function monthname($number)
{
	$months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

	return $months[$number - 1];
}

function firstNChar($string, $count)
{
	return substr($string, 0, $count);
}

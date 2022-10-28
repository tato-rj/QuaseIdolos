<?php

function showtags($str)
{
	return htmlspecialchars($str);
}

function uuid()
{
	return (string) \Str::uuid();
}

function datePtToUs($string)
{
	$pieces = explode('/', $string);

	if (count($pieces) == 3)
		return $pieces[1].'/'.$pieces[0].'/'.$pieces[2];
}

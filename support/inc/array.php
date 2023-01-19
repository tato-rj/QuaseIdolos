<?php

function randval($array)
{
	return $array[array_rand($array)];
}

function arrayToSentence($array, $conjunction = ' e ', $separator = ', ')
{
	$arrayCount = count($array);

	if ($arrayCount == 0) {
		return null;
	} elseif ($arrayCount == 1) {
	    $sentence = $array[0];
	} else {
	    $partial = array_slice($array, 0, $arrayCount-1);
	    $sentence = implode($separator, $partial) . "$conjunction" . $array[$arrayCount-1];
	}

	return $sentence;
}
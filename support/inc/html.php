<?php

function fa($icon, $color = null, $classes = null) {
	return '<i title="" name="" class="fas 
		   fa-'.$icon.' 
		   text-'.$color.' 
		   fa- 
		   '.$classes.'
		   t-2
		   " style=" "></i>';
}

function formMethod($method) {
	if (in_array(strtolower($method), ['delete', 'patch']))
		return 'POST';

	return $method;
}
<?php

function iftrue($var, $echo)
{
	return $var && $var === true ? $echo : null;
}
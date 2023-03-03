<?php

function is_route($url)
{
	return \Route::currentRouteName() == $url;
}

function subdomain()
{
	return str_replace('.', '', strbetween(url()->current(), '://', 'quaseidolos'));
}

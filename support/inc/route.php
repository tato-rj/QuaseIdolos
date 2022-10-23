<?php

function is_route($url)
{
	return \Route::currentRouteName() == $url;
}
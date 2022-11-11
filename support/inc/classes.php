<?php

function aws()
{
	return (new App\Storage\Providers\AWS);
}

function theme()
{
	return new \App\Brand\Theme;
}

function faker()
{
	return \Faker\Factory::create();
}

function hasPagination($collection)
{
	return $collection instanceof \Illuminate\Pagination\LengthAwarePaginator;
}

function carbon($str = null)
{
	return \Carbon\Carbon::parse($str);
}
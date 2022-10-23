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
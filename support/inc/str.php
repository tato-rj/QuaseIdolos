<?php

function showtags($str)
{
	return htmlspecialchars($str);
}

function uuid()
{
	return (string) \Str::uuid();
}

<?php

function percentage($num, $total)
{
	if ($total == 0)
		return 0;

	return (int)round(($num * 100) / $total);
}
<?php

namespace App\Models\Traits;

use App\Archives\Archives;

trait Archiveable
{
    public function archives()
    {
    	return (new Archives)->for($this);
    }
}
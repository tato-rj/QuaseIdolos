<?php

namespace App\Models\Traits;

use App\Archives\Archives;

trait Archiveable
{
    public function scopeArchives($query)
    {
    	return (new Archives)->for($this);
    }
}
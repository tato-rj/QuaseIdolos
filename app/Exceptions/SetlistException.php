<?php

namespace App\Exceptions;

use Exception;

class SetlistException extends Exception
{
    protected $errorBag = 'foo';

    public function render($request)
    {       
        return back()->with('setlist-error', $this->getMessage());
    }
}

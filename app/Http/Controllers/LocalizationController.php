<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function set($locale)
    {
        if (! in_array($locale, config('app.locales')))
            return back();

        if (auth()->check())
            // auth()->user()->update(['locale' => $locale]);

        \Session::put('lang', $locale);

        return back();
    }

    public function en()
    {
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function home()
    {
        return view('pages.home.index');
    }

    public function reservations()
    {
        return view('pages.reservas.index');
    }
}

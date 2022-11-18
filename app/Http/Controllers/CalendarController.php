<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;

class CalendarController extends Controller
{
    public function index()
    {
        $gigs = Gig::public()->upcoming()->get();

        return view('pages.calendar.index', compact('gigs'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;

class CalendarController extends Controller
{
    public function index()
    {
        $gigs = Gig::public()->upcoming()->orderBy('scheduled_for')->get();

        return view('pages.calendar.index', compact('gigs'));
    }
}

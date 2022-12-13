<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;

class CalendarController extends Controller
{
    public function index()
    {
        $calendar = Gig::public()->upcoming()->orderBy('scheduled_for')->get()->groupBy('dateForHumans');

        return view('pages.calendar.index', compact('calendar'));
    }
}

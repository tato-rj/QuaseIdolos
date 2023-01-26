<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;

class ParticipantsController extends Controller
{
    public function index(Gig $gig)
    {
        $this->authorize('viewParticipants', $gig);

        return view('pages.participants.index', compact('gig'));
    }
}

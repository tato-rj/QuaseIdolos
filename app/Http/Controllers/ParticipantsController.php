<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Gig, User, Participant};

class ParticipantsController extends Controller
{
    public function index(Gig $gig)
    {
        $this->authorize('viewParticipants', $gig);

        return view('pages.participants.index', compact('gig'));
    }

    public function remove(Participant $participant)
    {
        $participant->delete();

        return back()->with('success', 'O usuário foi removido desse evento');
    }
}

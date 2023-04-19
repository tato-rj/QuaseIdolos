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

    public function ban(Participant $participant)
    {
        $participant->user->ban();
        $participant->delete();

        return back()->with('success', 'O usuário foi removido e bloqueado com sucesso');
    }

    public function unban(User $user)
    {
        $user->unban();

        return back()->with('success', 'O usuário foi reativado com sucesso');
    }
}

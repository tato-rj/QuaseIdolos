<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetsController extends Controller
{
    public function reset()
    {
        $gig = auth()->user()->liveGig;

        if ($gig->setlist()->waiting()->exists())
            return back()->with('error', 'O set não pode ser resetado com músicas na lista de espera');

        $originalState = $gig->is_paused;

        $gig->update(['is_paused' => true]);

        $gig->sets()->current()->renew();

        $gig->update(['is_paused' => $originalState]);

        return back()->with('success', 'O set foi resetado com sucesso');
    }
}

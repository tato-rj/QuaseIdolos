<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetsController extends Controller
{
    public function reset()
    {
        $gig = auth()->user()->liveGig;

        abort_unless($gig, 404);

        $reset = $gig->withSetlistLock(function ($gig) {
            if ($gig->setlist()->waiting()->exists())
                return false;

            if ($set = $gig->sets()->first())
                $set->renew();

            return true;
        });

        if (! $reset)
            return back()->with('error', 'O set não pode ser resetado com músicas na lista de espera');

        return back()->with('success', 'O set foi resetado com sucesso');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\{SongRequestGuest, SongRequest, User};
use Illuminate\Http\Request;

class SongRequestGuestsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, SongRequest $songRequest, User $guest)
    {
        $this->authorize('invite', [$songRequest, $guest]);

        $songRequest->invite($guest);

        return back()->with('success', 'O seu convite foi enviado com sucesso');
    }

    public function confirm(Request $request, SongRequest $songRequest)
    {
        dd('here');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, SongRequest $songRequest, User $guest = null)
    {
        $songRequest->decline($guest ?? auth()->user());

        return back()->with('success', 'O convite foi cancelado com sucesso');
    }
}

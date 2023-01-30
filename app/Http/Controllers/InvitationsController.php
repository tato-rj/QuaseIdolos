<?php

namespace App\Http\Controllers;

use App\Models\{Invitation, SongRequest, User};
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, SongRequest $songRequest)
    {
        foreach ($request->participants as $participantId) {
            $this->authorize('invite', [$songRequest, User::find($participantId)]);
        }

        $songRequest->inviteMany($request->participants);

        return back()->with('success', 'O seu convite foi enviado com sucesso');
    }

    public function confirm(Request $request, $songRequestId)
    {
        $songRequest = SongRequest::find($songRequestId);

        if (! $songRequest)
            return back()->with('error', 'O convite já tinha sido cancelado');

        $invitation = Invitation::where([
            'song_request_id' => $songRequest->id,
            'user_id' => auth()->user()->id])->first();

        $invitation->confirm();

        return back()->with('invite-confirmed', true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, $songRequestId, User $guest = null)
    {
        $songRequest = SongRequest::find($songRequestId);

        if ($songRequest)
            $songRequest->decline($guest ?? auth()->user());

        return back()->with('success', 'O convite foi cancelado com sucesso');
    }
}

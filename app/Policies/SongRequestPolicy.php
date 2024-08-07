<?php

namespace App\Policies;

use App\Models\{SongRequest, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class SongRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SongRequest  $songRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SongRequest $songRequest)
    {
        if ($user->admin()->exists())
            return ! $user->admin->isSub();

        return $songRequest->user->is($user);
    }

    public function invite(User $user, SongRequest $songRequest, User $guest)
    {
        return $user->liveGig && $user->liveGig->participants->pluck('user')->contains($guest);
    }
}

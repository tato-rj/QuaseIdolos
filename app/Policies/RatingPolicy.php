<?php

namespace App\Policies;

use App\Models\{Rating, User, SongRequest};
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, SongRequest $songRequest)
    {
        $gig = $user->liveGig;

        return ! $songRequest->user->admin()->exists() 
                && $gig 
                && $user->participatesInRatings() 
                && $gig->participatesInRatings() 
                && ! $gig->winner()->exists();
    }
}

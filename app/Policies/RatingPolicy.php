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
        $gig = $user->liveGig();

        return ! $songRequest->user->isAdmin() 
                && $gig 
                && $user->participatesInRatings() 
                && $gig->participatesInRatings() 
                && ! $gig->winner()->exists();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Rating $rating)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Rating $rating)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Rating $rating)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Rating $rating)
    {
        //
    }
}

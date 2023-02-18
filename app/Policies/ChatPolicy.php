<?php

namespace App\Policies;

use App\Models\{User, Gig};
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function sendMessage(User $me, User $otherUser)
    {
        return ! $otherUser->blocked()->searchFor($me)->exists();
    }

    public function view(User $user)
    {
        return $user->liveGig ? $user->liveGig->participatesInChats() : false;
    }
}

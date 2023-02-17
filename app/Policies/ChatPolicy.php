<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function sendMessage(User $me, User $otherUser)
    {
        return ! $otherUser->blocked()->searchFor($me)->exists();
    }
}

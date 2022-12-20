<?php

namespace App\Policies;

use App\Models\Gig;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GigPolicy
{
    use HandlesAuthorization;

    public function open(User $user, Gig $gig)
    {
        return $gig->isReady();
    }
}

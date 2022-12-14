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

    public function join(User $user, Gig $gig)
    {
        if (! $gig->password()->required())
            return true;

        if ($gig->password != request()->password)
            return $this->deny('Você precisa ter a senha pra entrar nesse evento');

        return true;
    }
}

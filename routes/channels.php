<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Participant;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{gigId}', function ($user, $gigId) {
    return Participant::where(['gig_id' => $gigId, 'user_id' => $user->id])->exists();
});

<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Mail\Users\WelcomeEmail;
use App\Events\GigFinished;

class UserEventSubscriber
{
    public function handleUserRegistration($event)
    {
        \Mail::to($event->user->email)->queue(new WelcomeEmail($event->user));
    }

    public function subscribe($events)
    {
        return [
            Registered::class => 'handleUserRegistration',
            // GigFinished::class => 'sendWinnerEmail'
        ];
    }
}

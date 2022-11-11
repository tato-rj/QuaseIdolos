<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Mail\Users\WelcomeEmail;

class UserEventSubscriber
{
    public function handleUserRegistration($event)
    {
        \Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
    }

    public function subscribe($events)
    {
        return [
            Registered::class => 'handleUserRegistration',
        ];
    }
}
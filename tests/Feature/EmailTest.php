<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\User;
use App\Mail\Users\WelcomeEmail;
use Illuminate\Auth\Events\Registered;

class EmailTest extends AppTest
{
    /** @test */
    public function new_users_receive_a_welcome_email()
    {
        $request = User::factory()->make();

        $this->post(route('register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password
        ]);

        \Event::assertDispatched(Registered::class, function ($event) {
            return $event->user->is(auth()->user());
        });
        
        \Mail::assertSent(WelcomeEmail::class);
    }
}

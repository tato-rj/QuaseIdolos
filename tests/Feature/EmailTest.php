<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\User;
use App\Mail\Users\WelcomeEmail;

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

        \Mail::assertSent(WelcomeEmail::class);
    }
}

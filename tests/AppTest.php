<?php

namespace Tests;

use App\Models\{Admin, User};

class AppTest extends TestCase
{    
	public function setUp() : void
	{
		parent::setUp();

        // $this->superAdmin = Admin::factory(['super_admin' => true])->create();

        User::factory()->count(20)->create();
	}

    protected function signIn($user = null)
    {
        $user = $user ?? $this->admin;
        return $this->actingAs($user);
    }

    protected function logout()
    {
        \Auth::logout();
    }
}

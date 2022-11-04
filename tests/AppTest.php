<?php

namespace Tests;

use App\Models\{Admin, User, Song};

class AppTest extends TestCase
{    
	public function setUp() : void
	{
		parent::setUp();

        \Event::fake();
        \Storage::fake();
        
        $this->admin = Admin::factory()->create()->user;
        $this->song = Song::factory()->create();
	}

    protected function signIn($user = null)
    {
        $user = $user ?? User::factory()->create();
        return $this->actingAs($user);
    }

    protected function logout()
    {
        \Auth::logout();
    }
}

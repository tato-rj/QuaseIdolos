<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, SongRequest, Song};

class SocialLoginTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create();
    }

    /** @test */
    public function users_can_signup_with_facebook()
    {
        $this->get(route('socialite', 'facebook'));
    }
}
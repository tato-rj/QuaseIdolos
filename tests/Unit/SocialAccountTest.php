<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, SocialAccount};

class SocialAccountTest extends AppTest
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $socialAccount = SocialAccount::factory()->create();

        $this->assertInstanceOf(User::class, $socialAccount->user);
    }
}

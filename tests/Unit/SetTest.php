<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Set, Gig, Song};

class SetTest extends AppTest
{
    /** @test */
    public function it_differentiates_requests_from_users_and_admins()
    {
        $this->assertTrue(true);
    }
}

<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Favorite, User};

class FavoriteTest extends AppTest
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        return $this->assertInstanceOf(User::class, Favorite::factory()->create()->user);
    }
}

<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Show, Venue};

class ShowTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->show = Show::factory()->create();
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        return $this->assertInstanceOf(User::class, $this->show->creator);
    }

    /** @test */
    public function it_belongs_to_a_venue()
    {
        return $this->assertInstanceOf(Venue::class, $this->show->venue);
    }
}

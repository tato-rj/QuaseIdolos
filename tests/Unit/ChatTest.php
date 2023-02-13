<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Chat, Gig};

class ChatTest extends AppTest
{
    /** @test */
    public function it_has_many_senders()
    {
        $this->assertInstanceOf(User::class, Chat::factory()->create()->from);
    }

    /** @test */
    public function it_has_many_recipients()
    {
        $this->assertInstanceOf(User::class, Chat::factory()->create()->to);
    }

    /** @test */
    public function it_belongs_to_a_gig()
    {
        $this->assertInstanceOf(Gig::class, Chat::factory()->create()->gig);
    }
}

<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Chat};

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
}

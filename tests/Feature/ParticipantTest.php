<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\Gig;

class ParticipantTest extends AppTest
{
    // /** @test */
    // public function the_list_of_participants_is_stored_on_redis_once_the_gig_is_closed()
    // {
    //     Gig::truncate();

    //     $gig = Gig::factory()->live()->create();

    //     $this->signIn($this->superAdmin);

    //     $this->assertRedisEmpty();

    //     $this->signIn();

    //     auth()->user()->join($gig);

    //     $this->assertCount(1, $gig->participants);

    //     $this->assertCount(0, $gig->archives()->getParticipants());

    //     $this->signIn($this->superAdmin);

    //     $this->post(route('gig.close', $gig));

    //     $this->assertCount(1, $gig->participants);

    //     $this->assertCount(1, $gig->archives()->getParticipants());

    //     $this->assertRedisHas('test:gig:'.$gig->id.':participants');
    // }
}

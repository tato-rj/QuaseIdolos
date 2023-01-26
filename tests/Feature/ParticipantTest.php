<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, SongRequest, Participant, User};

class ParticipantTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create();
    }

    /** @test */
    public function users_can_see_all_participants_in_the_same_gig()
    {
        $this->signIn();

        $participant = User::factory()->create();

        auth()->user()->join($this->gig);

        $participant->join($this->gig);

        $this->get(route('gig.participants.index', $this->gig))->assertSee($participant->first_name);
    }

    /** @test */
    public function users_cannot_see_all_participants_in_the_same_gig()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        auth()->user()->join($this->gig);

        $this->get(route('gig.participants.index', Gig::factory()->create()));
    }
}

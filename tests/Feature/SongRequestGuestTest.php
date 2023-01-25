<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, SongRequest, User};
use App\Events\{SongRequested, SongCancelled, SongFinished};

class SongRequestGuestTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create();
    }

    /** @test */
    public function a_user_can_invite_another_user_to_sing_together()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $userA->join($this->gig);
        $userB->join($this->gig);

        $this->signIn($userA);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $userA]);

        $this->assertCount(0, $songRequest->guests);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $userB]));

        $this->assertCount(1, $songRequest->guests()->get());
    }

    /** @test */
    public function a_user_can_invite_another_user_who_isnt_in_the_same_event()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $userA = User::factory()->create(['name' => 'John Doe']);
        $userB = User::factory()->create(['name' => 'Jane Bar']);

        $userA->join($this->gig);

        $this->signIn($userA);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $userA]);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $userB]));
    }

    /** @test */
    public function a_user_can_decline_an_invitation()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $userA->join($this->gig);
        $userB->join($this->gig);

        $this->signIn($userA);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $userA]);

        $this->assertCount(0, $songRequest->guests);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $userB]));

        $this->assertCount(1, $songRequest->guests()->get());

        $this->signin($userB);

        $this->delete(route('song-requests.decline', $songRequest));

        $this->assertCount(0, $songRequest->guests()->get());
    }

    /** @test */
    public function a_user_can_cancel_an_invitation()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $userA->join($this->gig);
        $userB->join($this->gig);

        $this->signIn($userA);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $userA]);

        $this->assertCount(0, $songRequest->guests);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $userB]));

        $this->assertCount(1, $songRequest->guests()->get());

        $this->delete(route('song-requests.decline', ['songRequest' => $songRequest, 'guest' => $userB]));

        $this->assertCount(0, $songRequest->guests()->get());
    }

    /** @test */
    public function a_user_can_confirm_an_invitation()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $userA->join($this->gig);
        $userB->join($this->gig);

        $this->signIn($userA);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $userA]);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $userB]));

        $this->assertCount(0, $songRequest->guests()->confirmed()->get());

        $this->signin($userB);

        $this->patch(route('song-requests.confirm-invitation', $songRequest));

        $this->assertCount(1, $songRequest->guests()->confirmed()->get());
    }
}

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

    /** @test */
    public function when_a_song_request_is_deleted_its_guests_are_also_removed()
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $this->signIn($user);

        $user->join($this->gig);
        $guest->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $user]);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $guest]));

        $this->assertDatabaseHas('song_request_guests', ['user_id' => $guest->id]);

        $this->delete(route('song-requests.cancel', $songRequest));

        $this->assertDatabaseMissing('song_request_guests', ['user_id' => $guest->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_the_guests_for_its_song_requests_are_also_removed()
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $this->signIn($user);

        $user->join($this->gig);
        $guest->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $user]);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $guest]));

        $this->assertDatabaseHas('song_request_guests', ['user_id' => $guest->id]);

        $this->delete(route('profile.destroy'));

        $this->assertDatabaseMissing('song_request_guests', ['user_id' => $guest->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_its_guest_status_for_song_requests_is_also_removed()
    {
        $user = User::factory()->create();
        $guest = User::factory()->create();

        $this->signIn($user);

        $user->join($this->gig);
        $guest->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $user]);

        $this->post(route('song-requests.invite', ['songRequest' => $songRequest, 'guest' => $guest]));

        $this->assertDatabaseHas('song_request_guests', ['user_id' => $guest->id]);

        $this->signIn($guest);

        $this->delete(route('profile.destroy'));

        $this->assertDatabaseMissing('song_request_guests', ['user_id' => $guest->id]);
    }
}

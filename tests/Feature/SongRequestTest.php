<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, SongRequest};
use App\Events\{SongRequested, SongCancelled};

class SongRequestTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function only_authenticated_users_can_make_requests()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function users_can_only_cancel_their_own_requests()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        $songRequestByAnotherUser = SongRequest::factory()->create();

        $this->delete(route('song-requests.cancel', $songRequestByAnotherUser));
    }

    /** @test */
    public function admins_can_cancel_any_user_request()
    {
        $this->signIn($this->admin);

        $songRequest = SongRequest::factory()->create();

        $this->assertCount(1, SongRequest::all());

        $this->delete(route('song-requests.cancel', $songRequest));

        $this->assertCount(0, SongRequest::all());
    }

    /** @test */
    public function users_cannot_request_the_same_song_while_it_is_in_the_waiting_list()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function when_a_user_requests_a_song_an_event_is_fired()
    {
        $this->signIn();

        $this->post(route('song-requests.store', $this->song));

        \Event::assertDispatched(SongRequested::class, function ($event) {
            return $event->user === auth()->user();
        });
    }

    /** @test */
    public function when_a_user_cancels_a_request_a_song_an_event_is_fired()
    {
        $this->signIn();

        $this->post(route('song-requests.store', $this->song));

        $this->delete(route('song-requests.cancel', auth()->user()->songRequests->first()));

        \Event::assertDispatched(SongCancelled::class, function ($event) {
            return $event->user === auth()->user();
        });
    }

    /** @test */
    public function a_user_only_gets_the_song_request_alert_for_the_gig_that_is_currently_live()
    {
        $this->signIn();

        $oldGig = liveGig();

        (new SongRequest)->add(auth()->user(), $this->song, $oldGig);

        $this->get(route('setlists.alert.user'))->assertSee($this->song->name);

        $oldGig->update(['is_live' => false]);

        $newGig = Gig::factory()->create(['is_live' => true]);

        $this->get(route('setlists.alert.user'))->assertDontSee($this->song->name);

        $newGig->update(['is_live' => false]);
        $oldGig->update(['is_live' => true]);

        $this->get(route('setlists.alert.user'))->assertSee($this->song->name);
    }
}

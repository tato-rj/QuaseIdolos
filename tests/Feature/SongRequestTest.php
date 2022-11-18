<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, SongRequest, User};
use App\Events\{SongRequested, SongCancelled, SongFinished};

class SongRequestTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->create(['is_live' => true]);
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

        auth()->user()->join($this->gig);

        $songRequestByAnotherUser = SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        $this->delete(route('song-requests.cancel', $songRequestByAnotherUser));
    }

    /** @test */
    public function admins_can_cancel_any_user_request()
    {
        $this->signIn($this->admin);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig]);

        $this->assertCount(1, SongRequest::all());

        $this->delete(route('song-requests.cancel', $songRequest));

        $this->assertCount(0, SongRequest::all());
    }

    /** @test */
    public function users_cannot_request_the_same_song_in_the_same_setlist()
    {
        $this->expectException('\App\Exceptions\SetlistException');

        $this->signIn();

        $song = Song::factory()->create();

        $this->post(route('song-requests.store', $song));

        $this->post(route('song-requests.store', $song));
    }

    /** @test */
    public function users_can_request_the_same_song_in_the_same_gig_on_a_different_day()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'scheduled_for' => null]);

        auth()->user()->join($gig);

        $song = Song::factory()->create();

        $this->post(route('song-requests.store', $song));

        $this->travel(1)->days();

        $this->post(route('song-requests.store', $song));        
    }

    /** @test */
    public function admins_can_mark_a_song_request_as_finished()
    {
        $this->signIn($this->admin);

        auth()->user()->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        $this->assertFalse($songRequest->isOver());

        $this->post(route('song-requests.finish', $songRequest));

        $this->assertTrue($songRequest->fresh()->isOver());
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
    public function when_a_user_finishes_a_song_an_event_is_fired()
    {
        $this->signIn($this->admin);

        auth()->user()->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        $this->post(route('song-requests.finish', $songRequest));

        \Event::assertDispatched(SongFinished::class, function ($event) use ($songRequest) {
            return $event->songRequest->is($songRequest);
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
    public function a_user_only_gets_the_song_request_alert_if_the_gig_it_joined_is_live()
    {
        $this->signIn();
        
        auth()->user()->join($this->gig);

        (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->get(route('setlists.alert'))->assertSee($this->song->name);

        $this->gig->update(['is_live' => false]);

        $this->get(route('setlists.alert'))->assertDontSee($this->song->name);
    }

    /** @test */
    public function admins_only_see_requests_that_belong_to_the_same_event()
    {
        $this->signIn();

        $firstSong = Song::factory()->create(['name' => 'Firstsong']);

        (new SongRequest)->add(auth()->user(), $firstSong, $this->gig);

        $otherGig = Gig::factory()->create(['is_live' => true]);
        $otherSong = Song::factory()->create(['name' => 'Othersong']);

        $this->logout();

        $this->signIn();
        
        (new SongRequest)->add(auth()->user(), $otherSong, $otherGig);

        $this->logout();

        $this->signIn($this->admin);

        auth()->user()->join($this->gig);

        $this->get(route('setlists.admin'))
             ->assertSee($firstSong->name)
             ->assertDontSee($otherSong->name);

        auth()->user()->join($otherGig);

        $this->get(route('setlists.admin'))
             ->assertDontSee($firstSong->name)
             ->assertSee($otherSong->name);
    }

    /** @test */
    public function a_song_requested_by_an_admin_is_removed_when_finished()
    {
        $this->signIn($this->admin);
        
        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $this->gig]);

        $songRequest->finish();

        $this->assertDatabaseMissing('song_requests', ['id' => $songRequest->id]);
    }

    /** @test */
    public function an_admin_can_request_the_same_song_many_times_in_the_same_night()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn($this->admin);

        $song = Song::factory()->create();

        $this->post(route('song-requests.store', $song));

        $this->post(route('song-requests.store', $song));
    }

    /** @test */
    public function when_a_user_changes_gig_all_pending_requests_are_removed()
    {
        $otherGig = Gig::factory()->create(['is_live' => true]);

        $this->signIn();

        $pendingSong = Song::factory()->create();

        (new SongRequest)->add(auth()->user(), $pendingSong, $this->gig);
        
        $this->assertDatabaseHas('song_requests', ['song_id' => $pendingSong->id]);

        auth()->user()->join($otherGig);

        $this->assertDatabaseMissing('song_requests', ['song_id' => $pendingSong->id]);
    }
}

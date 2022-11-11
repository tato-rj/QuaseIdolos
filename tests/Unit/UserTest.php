<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, SongRequest, Gig, Admin, Rating, User};

class UserTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();

        $this->gig = Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function it_has_many_favorites()
    {
        auth()->user()->favorites()->save($this->song);

        return $this->assertInstanceOf(Song::class, auth()->user()->favorites->first());
    }

    /** @test */
    public function it_has_many_song_requests()
    {
        (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        return $this->assertInstanceOf(SongRequest::class, auth()->user()->songRequests->first());
    }

    /** @test */
    public function it_receives_many_ratings()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()]);

        Rating::factory()->create(['song_request_id' => $songRequest]);

        $this->assertInstanceOf(Rating::class, auth()->user()->ratings->first());
    }

    /** @test */
    public function it_gives_many_ratings()
    {
        $this->signIn();

        Rating::factory()->create(['user_id' => auth()->user()]);

        $this->assertInstanceOf(Rating::class, auth()->user()->ratingsGiven->first());
    }

    /** @test */
    public function it_knows_how_to_rate_another_user()
    {
        $this->signIn();

        $otherUser = User::factory()->create();

        $songRequest = SongRequest::factory()->create(['user_id' => $otherUser]);

        $this->assertFalse(Rating::to($otherUser)->exists());
        $this->assertFalse(Rating::from(auth()->user())->exists());

        auth()->user()->rate($songRequest, 4);

        $this->assertTrue(Rating::to($otherUser)->exists());
        $this->assertTrue(Rating::from(auth()->user())->exists());
    }

    /** @test */
    public function it_knows_its_ratings_for_a_given_song_request()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()]);

        auth()->user()->rate($songRequest, 4);

        $this->assertEquals(4, auth()->user()->ratingFor($songRequest));
    }

    /** @test */
    public function it_knows_how_to_enter_a_gig()
    {
        $this->assertFalse(auth()->user()->gig()->exists());

        auth()->user()->join(Gig::factory()->create(['is_live' => true]));

        $this->assertInstanceOf(Gig::class, auth()->user()->gig->first());
    }

    /** @test */
    public function if_it_joins_a_second_gig_it_automatically_swaps_between_the_two()
    {
        auth()->user()->join($this->gig);

        $this->assertCount(1, auth()->user()->gig);
        
        $this->assertTrue($this->gig->is(auth()->user()->fresh()->gig->first()));

        auth()->user()->join(Gig::factory()->create());

        $this->assertCount(1, auth()->user()->fresh()->gig);

        $this->assertFalse($this->gig->is(auth()->user()->fresh()->gig->first()));
    }

    /** @test */
    public function it_knows_if_it_is_an_admin()
    {
        $this->assertFalse(auth()->user()->isAdmin());

        (new Admin)->grant(auth()->user());

        $this->assertTrue(auth()->user()->isAdmin());
    }

    /** @test */
    public function it_knows_if_it_has_favorited_a_song()
    {
        $this->assertFalse(auth()->user()->favorited(Song::factory()->create()));

        $song = $this->song;

        auth()->user()->favorites()->save($song);

        $this->assertTrue(auth()->user()->favorited($song));
    }

    /** @test */
    public function it_knows_if_it_has_sung_a_song()
    {
        $this->assertFalse(auth()->user()->sung($this->song));

        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->assertFalse(auth()->user()->sung($this->song));

        $songRequest->finish();

        $this->assertTrue(auth()->user()->sung($this->song));
    }

    /** @test */
    public function it_knows_if_it_has_sung_a_song_in_a_given_gig_within_the_last_12_hours()
    {
        $this->assertFalse(auth()->user()->requestedTonight($this->song));

        auth()->user()->join($this->gig);

        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->liveGig());

        $this->assertTrue(auth()->user()->requestedTonight($this->song));
    }

    /** @test */
    public function it_knows_all_the_songs_it_is_waiting_to_sing()
    {
        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->assertInstanceOf(SongRequest::class, auth()->user()->requestsWaiting()->first());
    }

    /** @test */
    public function it_knows_all_the_songs_it_is_has_sung()
    {
        (new SongRequest)->add(auth()->user(), $this->song, $this->gig)->finish();
        
        $this->assertInstanceOf(SongRequest::class, auth()->user()->requestsSung()->first());
    }
}


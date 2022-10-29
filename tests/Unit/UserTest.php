<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, SongRequest, Gig, Admin};

class UserTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();

        $this->gig = Gig::factory()->create();
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


<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Gig, User};

class SongRequestTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->songRequest = SongRequest::factory()->create();
    }

    /** @test */
    public function it_belongs_to_a_gig()
    {
        return $this->assertInstanceOf(Gig::class, $this->songRequest->gig);
    }

    /** @test */
    public function it_belongs_to_a_song()
    {
        return $this->assertInstanceOf(Song::class, $this->songRequest->song);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        return $this->assertInstanceOf(User::class, $this->songRequest->user);
    }

    /** @test */
    public function it_knows_if_it_was_requested_by_a_specific_user()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();
        $songRequest = SongRequest::factory()->create([
            'user_id' => $user->id,
            'song_id' => $song->id
        ]);

        $this->assertNotTrue($songRequest->wasRequestedBy(User::factory()->create()));
        $this->assertTrue($songRequest->wasRequestedBy($user));
    }

    /** @test */
    public function it_knows_how_to_make_a_request()
    {
        $songRequest = (new SongRequest)->add(User::factory()->create(), Song::factory()->create(), Gig::factory()->create());

        $this->assertInstanceOf(SongRequest::class, $songRequest);
    }

    /** @test */
    public function it_knows_about_its_status()
    {
        $this->assertFalse($this->songRequest->isOver());

        $this->songRequest->finish();

        $this->assertTrue($this->songRequest->isOver());
    }
}

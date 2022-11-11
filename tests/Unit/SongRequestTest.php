<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Gig, User, Rating};

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
    public function it_has_many_ratings()
    {
        Rating::factory()->create(['song_request_id' => $this->songRequest->id]);

        return $this->assertInstanceOf(Rating::class, $this->songRequest->ratings->first());
    }

    /** @test */
    public function it_knows_its_average_score()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create();

        $this->assertNull($songRequest->ratings->avg('score'));

        auth()->user()->rate($songRequest, 4);

        $this->signIn();

        auth()->user()->rate($songRequest, 2);

        $this->assertEquals(3, $songRequest->fresh()->ratings->avg('score'));
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

    /** @test */
    public function it_knows_how_to_get_only_song_requests_since_the_starting_time_of_the_gig()
    {
        $this->signIn();

        $gig = Gig::factory()->create(['starts_at' => now()->copy()->subHour()]);

        $songRequest = SongRequest::factory()->create(['gig_id' => $gig->id, 'user_id' => auth()->user()->id, 'created_at' => now()->copy()->subHours(2)]);
        $songRequest = SongRequest::factory()->create(['gig_id' => $gig->id, 'user_id' => auth()->user()->id]);

        $this->assertCount(1, SongRequest::forGigTonight($gig)->get());
        $this->assertCount(2, SongRequest::forGig($gig)->get());
    }
}

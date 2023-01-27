<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Gig, User, Rating, Invitation};

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
        $this->assertInstanceOf(Gig::class, $this->songRequest->gig);
    }

    /** @test */
    public function it_belongs_to_a_song()
    {
        $this->assertInstanceOf(Song::class, $this->songRequest->song);
    }

    /** @test */
    public function it_has_many_guests()
    {
        Invitation::factory()->create(['song_request_id' => $this->songRequest->id]);

        $this->assertInstanceOf(Invitation::class, $this->songRequest->invitations->first());
    }

    /** @test */
    public function it_belongs_to_an_artist_through_its_song()
    {
        $this->assertInstanceOf(Artist::class, $this->songRequest->artist);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->songRequest->user);
    }

    /** @test */
    public function it_has_many_ratings()
    {
        Rating::factory()->create(['song_request_id' => $this->songRequest->id]);

        $this->assertInstanceOf(Rating::class, $this->songRequest->ratings->first());
    }

    /** @test */
    public function it_has_many_victories()
    {
        $gig = Gig::factory()->create(['winner_id' => $this->songRequest]);

        $this->assertInstanceOf(Gig::class, $this->songRequest->winners()->first());
    }

    /** @test */
    public function it_knows_its_confirmed_guests()
    {
        Invitation::factory()->create(['song_request_id' => $this->songRequest->id]);

        $this->assertCount(1, $this->songRequest->invitations);
        $this->assertCount(0, $this->songRequest->invitations()->confirmed()->get());

        $this->songRequest->invitations->first()->confirm();

        $this->assertCount(1, $this->songRequest->invitations()->confirmed()->get());
    }

    /** @test */
    public function it_knows_its_unconfirmed_guests()
    {
        Invitation::factory()->create(['song_request_id' => $this->songRequest->id]);

        $this->assertCount(1, $this->songRequest->invitations);
        $this->assertCount(1, $this->songRequest->invitations()->unconfirmed()->get());

        $this->songRequest->invitations->first()->confirm();

        $this->assertCount(0, $this->songRequest->invitations()->unconfirmed()->get());
    }

    /** @test */
    public function it_knows_its_average_score()
    {
        $song = SongRequest::factory()->create();

        $this->assertTrue($song->score() == 0);

        Rating::factory()->count(10)->create(['song_request_id' => $song]);

        $this->assertTrue($song->fresh()->score() > 0);
    }

    /** @test */
    public function its_average_score_takes_into_account_the_number_of_votes()
    {
        $gig = Gig::factory()->create();
        $songA = SongRequest::factory()->create(['gig_id' => $gig]);
        $songB = SongRequest::factory()->create(['gig_id' => $gig]);

        Rating::factory()->count(8)->create(['song_request_id' => $songA, 'score' => randomFromArray([4,5])]);

        Rating::factory()->count(2)->create(['song_request_id' => $songB, 'score' => 5]);

        $this->assertTrue($songA->score() > $songB->score());
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

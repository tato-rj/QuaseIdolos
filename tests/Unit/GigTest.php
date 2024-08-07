<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Gig, User, SongRequest, Participant, Rating, Venue, Set};

class GigTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->create([
            'songs_limit' => 2,
            'songs_limit_per_user' => 1
        ]);
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        return $this->assertInstanceOf(User::class, $this->gig->creator);
    }

    /** @test */
    public function it_belongs_to_a_venue()
    {
        return $this->assertInstanceOf(Venue::class, $this->gig->venue);
    }

    /** @test */
    public function it_has_many_musicians()
    {
        $this->gig->musicians()->save(User::factory()->create());
        
        return $this->assertInstanceOf(User::class, $this->gig->musicians->first());
    }

    /** @test */
    public function it_has_many_sets()
    {
        $this->gig->sets()->create([
            'limit' => 1
        ]);

        return $this->assertInstanceOf(Set::class, $this->gig->sets->first());
    }

    /** @test */
    public function it_has_a_winner()
    {
        $winner = SongRequest::factory()->create(['gig_id' => $this->gig]);

        $this->gig->winner()->associate($winner)->save();

        return $this->assertInstanceOf(SongRequest::class, $this->gig->winner);
    }

    /** @test */
    public function it_has_many_song_requests()
    {
        SongRequest::factory()->create(['gig_id' => $this->gig]);

        return $this->assertInstanceOf(SongRequest::class, $this->gig->setlist->first());
    }

    /** @test */
    public function it_has_many_participants()
    {
        $this->signIn();

        Participant::factory()->create(['gig_id' => $this->gig, 'user_id' => auth()->user()]);

        $this->assertInstanceOf(Participant::class, $this->gig->participants->first());
    }

    /** @test */
    public function it_knows_if_it_is_scheduled_for_today()
    {
        $this->assertTrue($this->gig->isToday());

        $this->assertFalse(Gig::factory()->create(['scheduled_for' => now()->copy()->subDay()])->isToday());
    }

    /** @test */
    public function it_knows_its_total_limit()
    {
        $this->assertFalse($this->gig->isFull());

        SongRequest::factory()->count(2)->create(['gig_id' => $this->gig]);

        $this->assertTrue($this->gig->fresh()->isFull());
    }

    /** @test */
    public function it_knows_its_limit_for_a_single_users()
    {
        $this->signIn();

        $this->assertFalse($this->gig->userLimitReached());

        SongRequest::factory()->create(['gig_id' => $this->gig, 'user_id' => auth()->user()]);

        $this->assertTrue($this->gig->fresh()->userLimitReached());
    }

    /** @test */
    public function it_knows_if_it_is_ready_to_start()
    {
        Gig::truncate();
        
        $gig = Gig::factory()->create(['scheduled_for' => now()->copy()->startOfDay()]);

        $this->assertTrue($gig->isReady());

        $this->travelTo(now()->copy()->addDay()->startOfDay());

        $this->assertTrue($gig->isReady());

        $this->travel(3)->hours();

        $this->assertTrue($gig->isReady());

        $this->travel(1)->hours();

        $this->assertFalse($gig->isReady());
    }

    /** @test */
    public function it_knows_the_ranking_from_its_participants()
    {
        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        $songRequest = SongRequest::factory()->create(['gig_id' => $gig, 'finished_at' => now()]);
        
        Rating::factory()->create(['user_id' => auth()->user(), 'song_request_id' => $songRequest]);

        $this->assertInstanceOf(Rating::class, $gig->ratings->first());
    }

    /** @test */
    public function it_knows_about_upcoming_events()
    {
        Gig::truncate();

        $pastGig = Gig::factory()->create(['scheduled_for' => now()->subWeek()]);
        $upcomingGig = Gig::factory()->create(['scheduled_for' => now()->addWeek()]);

        $this->assertCount(1, Gig::upcoming()->get());
        $this->assertTrue(Gig::upcoming()->first()->is($upcomingGig));

        Gig::factory()->create(['scheduled_for' => now()->addWeek()]);

        $this->assertCount(2, Gig::upcoming()->get());
    }

    /** @test */
    public function it_knows_how_to_generate_a_random_password()
    {
        $this->assertEquals(4, strlen($this->gig->password()->generate()));
    }

    /** @test */
    public function it_knows_if_it_has_passed_its_closing_time()
    {
        $gig = Gig::factory()->live()->create(['duration' => null]);
        $waitingGig = Gig::factory()->create();
        $currentGig = Gig::factory()->live()->create(['duration' => 2]);
        $pastGig = Gig::factory()->create(['starts_at' => now()->subHours(5), 'is_live' => true, 'duration' => 1]);

        $this->assertTrue($pastGig->shouldFinish());
        $this->assertFalse($gig->shouldFinish());
        $this->assertFalse($currentGig->shouldFinish());
        $this->assertFalse($waitingGig->shouldFinish());
    }

    /** @test */
    public function it_may_know_its_ending_time()
    {
        $gig = Gig::factory()->create(['duration' => 2]);

        $gig->open();
        
        $this->assertEquals($gig->endingTime()->hour, now()->addHours(2)->hour);
    }
}

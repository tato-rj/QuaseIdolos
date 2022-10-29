<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Gig, User, SongRequest};

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
    public function it_has_many_song_requests()
    {
        SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        return $this->assertInstanceOf(SongRequest::class, $this->gig->setlist->first());
    }

    /** @test */
    public function it_knows_if_it_is_scheduled_for_today()
    {
        $this->assertTrue($this->gig->isToday());

        $this->assertFalse(Gig::factory()->create(['date' => now()->copy()->subDay()])->isToday());
    }

    /** @test */
    public function it_knows_its_total_limit()
    {
        $this->assertFalse($this->gig->isFull());

        SongRequest::factory()->count(2)->create(['gig_id' => $this->gig->id]);

        $this->assertTrue($this->gig->fresh()->isFull());
    }

    /** @test */
    public function it_knows_its_limit_for_a_single_users()
    {
        $this->signIn();

        $this->assertFalse($this->gig->canTakeRequestsFromUser());

        SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => auth()->user()->id]);

        $this->assertTrue($this->gig->fresh()->canTakeRequestsFromUser());
    }

    /** @test */
    public function it_knows_if_it_is_ready_to_start()
    {
        $this->assertTrue($this->gig->isReady());

        $this->assertTrue(Gig::factory()->create(['date' => now()->copy()->startOfDay()])->isReady());

        $this->assertFalse(Gig::factory()->create(['date' => now()->copy()->addDay()])->isReady());
    }
}

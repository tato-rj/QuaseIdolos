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

        $this->assertFalse($this->gig->userLimitReached());

        SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => auth()->user()->id]);

        $this->assertTrue($this->gig->fresh()->userLimitReached());
    }

    /** @test */
    public function it_knows_if_it_is_ready_to_start()
    {
        Gig::truncate();
        
        $gig = Gig::factory()->create(['date' => now()->copy()->startOfDay()]);

        $this->assertTrue($gig->isReady());

        $this->travelTo(now()->copy()->addDay()->startOfDay());

        $this->assertTrue($gig->isReady());

        $this->travel(4)->hours();

        $this->assertTrue($gig->isReady());

        $this->travel(1)->hours();

        $this->assertFalse($gig->isReady());
    }

    /** @test */
    public function if_it_has_no_date_it_is_ready_to_start_at_any_time()
    {
        Gig::truncate();

        $gig = Gig::factory()->create(['date' => null]);

        $this->assertTrue($gig->isReady());
    }
}

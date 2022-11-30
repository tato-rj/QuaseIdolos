<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Gig, Venue};

class VenueTest extends AppTest
{
    /** @test */
    public function it_has_many_gigs()
    {
        $gig = Gig::factory()->create();

        return $this->assertInstanceOf(Gig::class, $gig->venue->gigs->first());
    }

    /** @test */
    public function it_knows_which_gigs_are_scheduled_for_today_and_not_today()
    {
        $venue = Venue::factory()->create();
        
        Gig::factory()->create(['venue_id' => $venue, 'scheduled_for' => now()]);

        Gig::factory()->create(['venue_id' => $venue, 'scheduled_for' => now()->addDays(2)]);

        $this->assertCount(2, $venue->gigs);

        $this->assertCount(1, $venue->gigs()->ready()->get());

        $this->assertCount(1, $venue->gigs()->notReady()->get());

        $this->assertNotEquals($venue->gigs()->ready()->get(), $venue->gigs()->notReady()->get());
    }
}

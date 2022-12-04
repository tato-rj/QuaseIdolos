<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Venue, Admin};

class VenueTest extends AppTest
{
    /** @test */
    public function when_a_venue_is_deleted_all_its_gigs_are_deleted()
    {
        Gig::truncate();
        Venue::truncate();

        $gig = Gig::factory()->create();
        $venue = $gig->venue;

        $this->signIn($this->superAdmin);

        $this->delete(route('venues.destroy', $venue));

        $this->assertDatabaseMissing('venues', ['id' => $venue]);

        $this->assertDatabaseMissing('gigs', ['id' => $gig]);
    }
}

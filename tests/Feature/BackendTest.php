<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{SongRequest, Gig};

class BackendTest extends AppTest
{
    /** @test */
    public function a_gig_is_automatically_closed_at_a_specified_time_cancelling_any_unfinished_song_requests()
    {
        $gig = Gig::factory()->create(['starts_at' => now()->subHours(5), 'is_live' => true, 'duration' => 1]);

        SongRequest::factory()->create(['gig_id' => $gig]);
        SongRequest::factory()->finished()->create(['gig_id' => $gig]);

        $otherGig = Gig::factory()->create();
        SongRequest::factory()->create(['gig_id' => $otherGig]);

        $this->assertEquals(SongRequest::count(), 3);

        $this->artisan('gigs:close')->assertSuccessful();

        $this->assertEquals(SongRequest::count(), 2);
    }
}

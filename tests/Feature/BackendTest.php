<?php

namespace Tests\Feature;

use Tests\AppTest;

class BackendTest extends AppTest
{
    /** @test */
    public function a_gig_is_automatically_closed_at_a_specified_time()
    {
        $gig = Gig::factory()->live()->create();

        // SongRequest::factory()->
    }
}

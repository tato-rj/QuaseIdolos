<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Rating, SongRequest, Gig};

class RatingTest extends AppTest
{
    /** @test */
    public function it_knows_the_ratings_given_from_a_user()
    {
        $this->signIn();

        $this->assertCount(0, Rating::from(auth()->user())->get());

        Rating::factory()->create(['user_id' => auth()->user()]);

        $this->assertCount(1, Rating::from(auth()->user())->get());
    }

    /** @test */
    public function it_knows_the_ratings_given_to_a_user()
    {
        $this->signIn();

        $this->assertCount(0, Rating::to(auth()->user())->get());

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()]);

        Rating::factory()->create(['song_request_id' => $songRequest]);

        $this->assertCount(1, Rating::to(auth()->user())->get());
    }
}

<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\Song;

class FavoriteTest extends AppTest
{
    /** @test */
    public function a_user_cannot_favorite_the_same_song_twice()
    {
        $this->signIn();

        $song = Song::factory()->create();

        $this->post(route('favorites.store', $song));

        $this->post(route('favorites.store', $song));

        $this->assertCount(1, auth()->user()->favorites()->get());
    }
}

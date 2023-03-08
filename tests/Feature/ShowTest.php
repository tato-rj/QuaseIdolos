<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Show, Song};

class ShowTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->show = Show::factory()->create();
    }

    /** @test */
    public function an_admin_can_add_or_remove_a_song_from_the_setlist()
    {
        $this->signIn($this->superAdmin);

        $song = Song::factory()->create();

        $this->assertCount(0, $this->show->setlist()->get());

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $song]));

        $this->assertCount(1, $this->show->setlist()->get());

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $song]));

        $this->assertCount(0, $this->show->setlist()->get());
    }
}

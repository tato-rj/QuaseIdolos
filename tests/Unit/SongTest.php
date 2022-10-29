<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Favorite, User};

class SongTest extends AppTest
{
    /** @test */
    public function it_belongs_to_an_artist()
    {
        $this->assertInstanceOf(Artist::class, $this->song->artist);
    }

    /** @test */
    public function it_can_belong_to_many_song_requests()
    {
        $this->signIn();

        SongRequest::factory()->create(['song_id' => $this->song->id]);

        $this->assertInstanceOf(SongRequest::class, $this->song->songRequests->first());
    }

    /** @test */
    public function it_can_belong_to_many_favorites()
    {
        $this->signIn();

        Favorite::factory()->create(['song_id' => $this->song->id]);

        $this->assertInstanceOf(User::class, $this->song->favorites->first());
    }

    /** @test */
    public function it_knows_how_to_generate_a_chords_url()
    {
        $this->assertNotNull(Song::factory()->create()->generateChordsUrl());
    }
}

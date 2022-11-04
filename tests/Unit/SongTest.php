<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Favorite, User, Genre};

class SongTest extends AppTest
{
    /** @test */
    public function it_belongs_to_an_artist()
    {
        $this->assertInstanceOf(Artist::class, $this->song->artist);
    }

    /** @test */
    public function it_belongs_to_a_genre()
    {
        $this->assertInstanceOf(Genre::class, $this->song->genre);
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

    /** @test */
    public function it_knows_how_many_times_it_has_been_favorited()
    {
        $this->assertEquals(0, $this->song->favorites_count);

        Favorite::factory()->create(['song_id' => $this->song->id]);
        
        $this->assertEquals(1, $this->song->fresh()->favorites_count);
    }

    /** @test */
    public function it_knows_how_many_times_it_has_been_sung()
    {
        $this->assertEquals(0, $this->song->completed_count);

        SongRequest::factory()->create(['song_id' => $this->song->id]);
        SongRequest::factory()->create(['song_id' => $this->song->id, 'finished_at' => now()]);
        
        $this->assertEquals(1, $this->song->fresh()->completed_count);
    }
}

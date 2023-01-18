<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Genre, SongRequest};

class GenreTest extends AppTest
{
    /** @test */
    public function it_has_many_songs()
    {
        return $this->assertInstanceOf(Song::class, Genre::first()->songs->first());
    }

    /** @test */
    public function it_has_many_songRequests_through_its_songs()
    {
        SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['genre_id' => Genre::first()])
        ]);

        return $this->assertInstanceOf(SongRequest::class, Genre::first()->songRequests->first());
    }
}


<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest};

class ArtistTest extends AppTest
{
    /** @test */
    public function it_has_many_songs()
    {
        return $this->assertInstanceOf(Song::class, Artist::first()->songs->first());
    }

    /** @test */
    public function it_has_many_songRequests_through_its_songs()
    {
        SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['artist_id' => Artist::first()])
        ]);

        return $this->assertInstanceOf(SongRequest::class, Artist::first()->songRequests->first());
    }
}

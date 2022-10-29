<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist};

class ArtistTest extends AppTest
{
    /** @test */
    public function it_has_many_songs()
    {
        return $this->assertInstanceOf(Song::class, Artist::first()->songs->first());
    }
}

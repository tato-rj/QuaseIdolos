<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Genre};

class GenreTest extends AppTest
{
    /** @test */
    public function it_has_many_songs()
    {
        return $this->assertInstanceOf(Song::class, Genre::first()->songs->first());
    }
}


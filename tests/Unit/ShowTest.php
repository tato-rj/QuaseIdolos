<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{User, Show, Venue, Song};

class ShowTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->show = Show::factory()->create();
    }

    /** @test */
    public function it_belongs_to_a_creator()
    {
        return $this->assertInstanceOf(User::class, $this->show->creator);
    }

    /** @test */
    public function it_belongs_to_a_venue()
    {
        return $this->assertInstanceOf(Venue::class, $this->show->venue);
    }

    /** @test */
    public function it_has_many_songs()
    {
        $this->show->setlist()->save(Song::factory()->create());

        return $this->assertInstanceOf(Song::class, $this->show->setlist->first());
    }

    /** @test */
    public function it_has_many_musicians()
    {
        $this->show->musicians()->save(User::factory()->create());
        
        return $this->assertInstanceOf(User::class, $this->show->musicians->first());
    }
}

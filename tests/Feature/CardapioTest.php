<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Song, Artist, Genre};

class CardapioTest extends AppTest
{
    /** @test */
    public function a_guest_can_search_by_song()
    {
        $song = Song::factory()->create(['name' => 'Some song']);

        $this->get(route('cardapio.search', ['input' => 'some']))->assertSee($song->name);
    }

    /** @test */
    public function a_guest_can_search_by_artist()
    {
        $song = Song::factory()->create(['artist_id' => Artist::factory()->create(['name' => 'John Doe'])->id]);

        $this->get(route('cardapio.search', ['input' => 'john']))->assertSee($song->name);
    }

    /** @test */
    public function a_guest_can_search_by_tag()
    {
        $song = Song::factory()->create(['tags' => 'foo bar']);

        $this->get(route('cardapio.search', ['input' => 'foo']))->assertSee($song->name);
    }

    /** @test */
    public function a_guest_can_search_by_genre()
    {
        $genre = Genre::factory()->create(['name' => 'foo']);
        $song = Song::factory()->create(['genre_id' => $genre->id]);

        $this->get(route('cardapio.search', ['input' => 'foo']))->assertSee($song->name);
    }
}

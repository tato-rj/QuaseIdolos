<?php

namespace Tests\Feature;

use Tests\AppTest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\{Artist, Song};

class ArtistTest extends AppTest
{
    /** @test */
    public function when_an_artist_is_deleted_all_its_songs_and_image_are_deleted()
    {
        Song::truncate();
        Artist::truncate();

        $this->signIn($this->admin);

        $this->post(route('artists.store'), ['name' => 'Mary', 'image' => UploadedFile::fake()->image('cover.jpg')]);

        $artist = Artist::first();

        $song = Song::factory()->create(['artist_id' => $artist]);

        Storage::disk('public')->assertExists($artist->image_path);

        $this->delete(route('artists.destroy', $artist));

        Storage::disk('public')->assertMissing($artist->image_path);

        $this->assertDatabaseMissing('songs', ['id' => $song]);
    }

    /** @test */
    public function if_an_artist_is_hidden_it_will_not_show_on_the_cardapio_page()
    {
        Artist::truncate();
        $visibleArtist = Artist::factory()->create();
        $hiddenArtist = Artist::factory()->hidden()->create();

        Song::factory()->create(['artist_id' => $visibleArtist]);
        Song::factory()->create(['artist_id' => $hiddenArtist]);

        $this->get(route('cardapio.index'))
             ->assertSee($visibleArtist->name)
             ->assertDontSee($hiddenArtist->name);
    }

    /** @test */
    public function if_an_artist_is_hidden_it_will_not_show_up_in_the_search()
    {
        Artist::truncate();
        $visibleArtist = Artist::factory()->create();
        $hiddenArtist = Artist::factory()->hidden()->create();

        Song::factory()->create(['artist_id' => $visibleArtist]);
        Song::factory()->create(['artist_id' => $hiddenArtist]);

        $this->get(route('cardapio.search', ['input' => $hiddenArtist->name]))->assertDontSee($hiddenArtist->name);
        $this->get(route('cardapio.index', ['artista' => $hiddenArtist->slug]))->assertDontSee($hiddenArtist->name);

        $this->get(route('cardapio.search', ['input' => $visibleArtist->name]))->assertSee($visibleArtist->name);
        $this->get(route('cardapio.index', ['artista' => $visibleArtist->slug]))->assertSee($visibleArtist->name);
    }

    /** @test */
    public function if_an_artist_is_hidden_it_songs_will_not_show_up_in_the_search()
    {
        Artist::truncate();
        Song::truncate();
        $visibleSong = Song::factory()->create(['artist_id' => Artist::factory()->create(), 'name' => 'UniqueVisibleSong']);
        $hiddenSong = Song::factory()->create(['artist_id' => Artist::factory()->hidden()->create(), 'name' => 'UniqueHiddenSong']);

        $this->get(route('cardapio.search', ['input' => $hiddenSong->name]))->assertDontSee($hiddenSong->name);
        $this->get(route('cardapio.index', ['musica' => $hiddenSong->id]))->assertDontSee($hiddenSong->name);

        $this->get(route('cardapio.search', ['input' => $visibleSong->name]))->assertSee($visibleSong->name);
        $this->get(route('cardapio.index', ['musica' => $visibleSong->id]))->assertSee($visibleSong->name);
    }

    /** @test */
    public function if_an_artist_is_hidden_it_songs_will_not_show_up_in_the_genre_search()
    {
        Artist::truncate();
        Song::truncate();
        $visibleSong = Song::factory()->create(['artist_id' => Artist::factory()->create(), 'name' => 'UniqueVisibleSong']);
        $hiddenSong = Song::factory()->create(['artist_id' => Artist::factory()->hidden()->create(), 'name' => 'UniqueHiddenSong']);

        $this->get(route('cardapio.search', ['input' => $hiddenSong->genre->name]))->assertDontSee($hiddenSong->name);
        $this->get(route('cardapio.index', ['estilo' => $hiddenSong->genre->slug]))->assertDontSee($hiddenSong->name);

        $this->get(route('cardapio.search', ['input' => $visibleSong->genre->name]))->assertSee($visibleSong->name);
        $this->get(route('cardapio.index', ['estilo' => $visibleSong->genre->slug]))->assertSee($visibleSong->name);
    }
}

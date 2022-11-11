<?php

namespace Tests\Feature;

use Tests\AppTest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\{Genre, Song};

class GenreTest extends AppTest
{
    /** @test */
    public function when_an_artist_is_deleted_all_its_songs_and_image_are_deleted()
    {
        Genre::truncate();
        Song::truncate();

        $this->signIn($this->admin);

        $this->post(route('genres.store'), ['name' => 'Axe', 'image' => UploadedFile::fake()->image('cover.jpg')]);

        $genre = Genre::first();

        $song = Song::factory()->create(['genre_id' => $genre]);

        Storage::disk('public')->assertExists($genre->image_path);

        $this->delete(route('genres.destroy', $genre));

        Storage::disk('public')->assertMissing($genre->image_path);

        $this->assertDatabaseMissing('songs', ['id' => $song]);
    }
}

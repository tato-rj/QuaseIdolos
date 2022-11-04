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

        $song = Song::factory()->create(['artist_id' => $artist->id]);

        Storage::disk('public')->assertExists($artist->image_path);

        $this->delete(route('artists.destroy', $artist));

        Storage::disk('public')->assertMissing($artist->image_path);

        $this->assertDatabaseMissing('songs', ['id' => $song->id]);
    }
}

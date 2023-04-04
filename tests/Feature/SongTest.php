<?php

namespace Tests\Feature;

use Tests\AppTest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\{SongRequest, Song};

class SongTest extends AppTest
{
    /** @test */
    public function when_a_song_is_deleted_all_its_requests_are_also_deleted()
    {
        Storage::fake();

        $this->signIn($this->admin);

        SongRequest::truncate();

        SongRequest::factory()->create(['song_id' => $this->song->id]);

        $this->delete(route('songs.destroy', $this->song));

        $this->assertEmpty(SongRequest::all());
    }

    /** @test */
    public function when_a_song_is_deleted_its_drums_score_is_also_deleted()
    {
        Storage::fake();
        Song::truncate();

        $this->signIn($this->admin);

        $request = Song::factory()->make();

        $request->drum_score = UploadedFile::fake()->image('score.jpg');

        $this->post(route('songs.store'), $request->toArray());

        $song = Song::first();

        Storage::disk('public')->assertExists($song->drum_score_path);

        $this->delete(route('songs.destroy', $song));

        Storage::disk('public')->assertMissing($song->drum_score_path);

        $this->assertDatabaseMissing('songs', ['id' => $song]);
    }
}

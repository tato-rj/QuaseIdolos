<?php

namespace Tests\Feature;

use Tests\AppTest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\SongRequest;

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
}

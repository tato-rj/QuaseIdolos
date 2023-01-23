<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Admin, SongRequest, Song, Gig};

class TeamTest extends AppTest
{
    /** @test */
    public function a_sub_cannot_reorder_to_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();
        
        auth()->user()->join(Gig::factory()->live()->create());

        $gig = auth()->user()->gig()->live()->first();

        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);

        $oldSetlist = $gig->setlist;

        $this->logout();

        $this->signIn(Admin::factory()->sub()->create()->user);

        $newOrder = [
            json_encode(['id' => 1, 'order' => 2]),
            json_encode(['id' => 2, 'order' => 3]),
            json_encode(['id' => 3, 'order' => 1]),
        ];

        $this->get(route('setlists.table', ['newOrder' => $newOrder]));
    }

    /** @test */
    public function a_sub_cannot_confirm_a_song_in_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn(Admin::factory()->sub()->create()->user);

        auth()->user()->join(Gig::factory()->live()->create());

        $songRequest = SongRequest::factory()->create(['gig_id' => auth()->user()->gig()->live()->first()]);

        $this->post(route('song-requests.finish', $songRequest));
    }

    /** @test */
    public function a_sub_cannot_remove_a_song_in_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn(Admin::factory()->sub()->create()->user);

        auth()->user()->join(Gig::factory()->live()->create());

        $songRequest = SongRequest::factory()->create(['gig_id' => auth()->user()->gig()->live()->first()]);

        $this->delete(route('song-requests.cancel', $songRequest));
    }
}

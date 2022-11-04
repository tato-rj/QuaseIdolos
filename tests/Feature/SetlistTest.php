<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, SongRequest, Song};

class SetlistTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function admins_can_see_songs_in_the_setlist()
    {
        $this->signIn($this->admin);

        (new SongRequest)->add(auth()->user(), $this->song, liveGig());

        $this->get(route('setlists.admin'))->assertSee($this->song->name);
    }

    /** @test */
    public function only_admins_can_see_songs_in_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        (new SongRequest)->add(auth()->user(), $this->song, liveGig());

        $this->get(route('setlists.admin'));
    }

    /** @test */
    public function admins_can_reorder_a_setlist()
    {
        $this->signIn();

        $gig = liveGig();

        (new SongRequest)->add(auth()->user(), Song::factory()->create(), liveGig());
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), liveGig());
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), liveGig());

        $oldSetlist = $gig->setlist;

        $this->logout();

        $this->signIn($this->admin);

        $newOrder = [
            json_encode(['id' => 1, 'order' => 2]),
            json_encode(['id' => 2, 'order' => 3]),
            json_encode(['id' => 3, 'order' => 1]),
        ];

        $this->get(route('setlists.table', ['newOrder' => $newOrder]));

        $this->assertNotEquals($oldSetlist, $gig->fresh()->setlist);
    }
}

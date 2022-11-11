<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, SongRequest, Song};

class SetlistTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function admins_can_see_songs_in_the_setlist()
    {
        $this->signIn($this->admin);

        auth()->user()->join($this->gig);

        (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->liveGig());

        $this->get(route('setlists.admin'))->assertSee($this->song->name);
    }

    /** @test */
    public function only_admins_can_see_songs_in_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        auth()->user()->join($this->gig);

        (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->liveGig());

        $this->get(route('setlists.admin'));
    }

    /** @test */
    public function admins_can_reorder_a_setlist()
    {
        $this->signIn();
        
        auth()->user()->join($this->gig);
        
        $gig = auth()->user()->liveGig();

        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);
        (new SongRequest)->add(auth()->user(), Song::factory()->create(), $gig);

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

    /** @test */
    public function admin_requests_can_exceed_the_user_limit_set_by_the_gig()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'songs_limit_per_user' => 1]);
        
        auth()->user()->join($gig);
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function admin_requests_can_exceed_the_total_limit_set_by_the_gig()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true, 'songs_limit' => 1]);
        
        auth()->user()->join($gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->post(route('song-requests.store', Song::factory()->create()));
    }
}

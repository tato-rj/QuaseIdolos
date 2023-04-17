<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, SongRequest, Song};
use App\Events\SetlistReordered;

class SetlistTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create();
    }

    /** @test */
    public function admins_can_see_songs_in_the_setlist()
    {
        $this->signIn($this->admin);

        auth()->user()->join($this->gig);

        (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->gig()->live()->first());

        $this->get(route('setlists.admin'))->assertSee($this->song->name);
    }

    /** @test */
    public function only_admins_can_see_songs_in_the_setlist()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        auth()->user()->join($this->gig);

        (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->gig()->live()->first());

        $this->get(route('setlists.admin'));
    }

    /** @test */
    public function admins_can_reorder_a_setlist()
    {
        $this->signIn();
        
        auth()->user()->join($this->gig);
        
        $gig = auth()->user()->gig()->live()->first();

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
    public function when_a_setlist_is_reordered_an_event_is_fired()
    {
        $this->signIn();
        
        auth()->user()->join($this->gig);
        
        $gig = auth()->user()->gig()->live()->first();

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

        \Event::assertDispatched(SetlistReordered::class);
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

    /** @test */
    public function when_a_request_is_completed_the_order_of_the_rest_of_the_list_is_updated()
    {
        $this->signIn();

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $firstRequest = SongRequest::find(1);
        $secondRequest = SongRequest::find(2);

        $this->signIn($this->admin);

        $this->assertEquals(1, $secondRequest->order);

        $this->post(route('song-requests.finish', $firstRequest));

        $this->assertEquals(0, $secondRequest->fresh()->order);
    }

    /** @test */
    public function when_a_request_is_cancelled_the_order_of_the_rest_of_the_list_is_updated()
    {
        $this->signIn();

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $firstRequest = SongRequest::find(1);
        $secondRequest = SongRequest::find(2);

        $this->signIn($this->admin);

        $this->assertEquals(1, $secondRequest->order);

        $this->delete(route('song-requests.cancel', $firstRequest));

        $this->assertEquals(0, $secondRequest->fresh()->order);
    }

    /** @test */
    public function the_site_does_not_crash_if_a_user_delete_their_account_before_the_song_request_is_confirmed()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn();

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $firstRequest = SongRequest::find(1);

        $this->delete(route('profile.destroy'));

        $this->signIn($this->admin);

        $this->post(route('song-requests.finish', $firstRequest));
    }

    /** @test */
    public function users_can_submit_requests_until_the_local_set_is_full()
    {
        $this->expectNotToPerformAssertions();
        $this->signIn();

        $this->gig->update(['current_set_limit' => 2]);

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function users_cannot_submit_requests_once_the_local_set_is_full()
    {
        $this->expectException('\App\Exceptions\SetlistException');
        $this->signIn();

        $this->gig->update(['current_set_limit' => 2]);

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function once_full_users_have_to_wait_for_the_set_to_finish_to_send_new_requests()
    {
        $this->expectException('\App\Exceptions\SetlistException');
        $this->signIn();

        $this->gig->update(['current_set_limit' => 2]);

        auth()->user()->join($this->gig);

        $this->assertFalse($this->gig->setIsFull());

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertTrue($this->gig->fresh()->setIsFull());

        $this->gig->setlist()->waiting()->first()->finish();

        $this->assertTrue($this->gig->fresh()->setIsFull());

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function users_have_to_wait_for_the_last_request_of_a_set_to_be_confirmed_before_they_can_submit_a_new_one()
    {
        $this->expectNotToPerformAssertions();
        $user = $this->signIn();

        $this->gig->update(['current_set_limit' => 2]);

        auth()->user()->join($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->admin);

        foreach($this->gig->setlist()->waiting()->get() as $request) {
            $this->post(route('song-requests.finish', $request));
        }

        $this->signIn($user);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->admin);
        
        foreach($this->gig->setlist()->waiting()->get() as $request) {
            $this->post(route('song-requests.finish', $request));
        }

        $this->signIn($user);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
    }
}

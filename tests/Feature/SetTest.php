<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Set, Song, SongRequest};

class SetTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create(['set_limit' => 2]);
    }

    /** @test */
    public function a_gig_automatically_creates_a_set_when_turned_on()
    {        
        $this->signIn($this->superAdmin);

        $this->assertNotTrue($this->gig->sets()->exists());

        $this->post($this->gig->openRoute());
        
        $this->assertTrue($this->gig->sets()->exists());
    }

    /** @test */
    public function the_set_is_deleted_when_the_gig_is_closed()
    {
        $this->signIn($this->superAdmin);

        $this->post($this->gig->openRoute());
        
        $this->assertTrue($this->gig->sets()->exists());

        $this->post($this->gig->closeRoute());

        $this->assertNotTrue($this->gig->sets()->exists());
    }

    /** @test */
    public function a_set_cannot_be_reset_when_the_waiting_list_is_not_empty()
    {
        $this->signIn();

        $this->gig->update(['set_limit' => 4]);

        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);

        $this->signIn($this->admin);

        $this->post(route('setlists.set.reset'));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);
    }

    /** @test */
    public function a_set_can_be_reset_when_the_waiting_list_is_empty()
    {
        $this->signIn();

        $this->gig->update(['set_limit' => 4]);

        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);

        $this->signIn($this->admin);

        $this->post(route('song-requests.finish', SongRequest::find(1)));
        $this->post(route('song-requests.finish', SongRequest::find(2)));

        $this->post(route('setlists.set.reset'));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 4);
    }

    /** @test */
    public function once_full_a_set_stops_accepting_requests_until_it_ends()
    {
        $this->signIn($this->admin);
        
        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertTrue($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.finish', SongRequest::first()));
        
        $this->assertTrue($this->gig->sets()->current()->isFinished());
    }

    /** @test */
    public function as_requests_are_completed_the_remaining_count_stays_the_same_until_the_set_is_full()
    {
        $this->signIn();

        $this->gig->update(['set_limit' => 4]);

        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);

        $this->signIn($this->admin);

        $this->post(route('song-requests.finish', SongRequest::find(1)));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);
    }

    /** @test */
    public function once_full_a_accepts_new_requests_if_one_is_cancelled()
    {
        $this->signIn($this->admin);
        
        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertTrue($this->gig->sets()->current()->isFinished());
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 0);

        $this->delete(route('song-requests.cancel', SongRequest::first()));
        
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 1);
        $this->assertFalse($this->gig->sets()->current()->isFinished());
    }

    /** @test */
    public function if_not_full_a_accepts_an_extra_new_requests_if_one_is_cancelled()
    {
        $this->signIn();

        $this->gig->update(['set_limit' => 4]);
        
        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 2);
        
        $this->signIn($this->admin);
        
        $this->delete(route('song-requests.cancel', SongRequest::first()));
        
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 3);
    }

    /** @test */
    public function a_set_keeps_track_of_the_songs_added_to_the_queue()
    {
        $this->signIn();

        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertEquals($this->gig->sets()->first()->queue, 1);
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 1);
    }

    /** @test */
    public function a_set_keeps_track_of_the_cancelled_songs()
    {
        $this->signIn();

        Set::new($this->gig);

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertEquals($this->gig->sets()->first()->queue, 2);
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 0);

        $this->delete(route('song-requests.cancel', SongRequest::first()));

        $this->assertEquals($this->gig->sets()->first()->queue, 1);
        $this->assertEquals($this->gig->sets()->first()->songsLeft(), 1);
    }

    /** @test */
    public function a_set_stops_incrementing_when_the_limit_has_been_reached()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        Set::new($this->gig);

        $this->assertFalse($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->assertTrue($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.store', Song::factory()->create()));   
    }

    /** @test */
    public function a_set_resets_when_the_last_song_request_is_confirmed_and_the_set_is_full()
    {
        $this->signIn();

        Set::new($this->gig);

        $this->assertFalse($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->assertTrue($this->gig->sets()->current()->isFinished());

        $this->signIn($this->admin);

        $this->post(route('song-requests.finish', SongRequest::find(1)));

        $this->assertTrue($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.finish', SongRequest::find(2)));

        $this->assertFalse($this->gig->sets()->current()->isFinished());
    }

    /** @test */
    public function a_set_will_not_accept_requests_if_the_setlist_is_full()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        Set::new($this->gig);
        
        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->admin);

        $this->post(route('song-requests.finish', SongRequest::find(1)));

        $this->signIn();

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_set_accepts_admin_requests_even_if_it_is_full()
    {
        $this->expectNotToPerformAssertions();
        
        $this->signIn();

        Set::new($this->gig);
        
        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->admin);

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_set_with_extra_admin_requests_still_waits_for_all_requests_to_complete_before_renewing()
    {
        $this->signIn();

        Set::new($this->gig);
        
        $this->post(route('song-requests.store', Song::factory()->create()));
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->admin);

        $this->post(route('song-requests.store', Song::factory()->create()));
        
        $this->post(route('song-requests.finish', SongRequest::find(1)));
        $this->post(route('song-requests.finish', SongRequest::find(2)));

        $this->assertTrue($this->gig->sets()->current()->isFinished());

        $this->post(route('song-requests.finish', SongRequest::find(3)));

        $this->assertFalse($this->gig->sets()->current()->isFinished());
    }
}

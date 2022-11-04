<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, Admin, SongRequest};

class GigTest extends AppTest
{
    /** @test */
    public function admins_dont_even_see_the_toggle_button_if_the_gig_is_not_ready()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        Gig::truncate();

        $gig = Gig::factory()->create(['date' => now()->copy()->addDays(3)]);

        $this->get(route('gig.index'))->assertDontSee(route('gig.status', $gig));

        $this->travel(3)->days();

        $this->get(route('gig.index'))->assertSee(route('gig.status', $gig));
    }

    /** @test */
    public function admins_dont_even_see_the_pause_button_if_the_gig_is_not_live()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        Gig::truncate();

        $gig = Gig::factory()->create(['is_live' => true]);

        $this->get(route('gig.index'))->assertSee(route('gig.pause', $gig));

        $gig->update(['is_live' => false]);

        $this->get(route('gig.index'))->assertDontSee(route('gig.pause', $gig));   
    }

    /** @test */
    public function a_gig_cannot_go_live_if_there_is_another_one_already_live()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gigOne = Gig::factory()->create(['is_live' => false]);
        $gigTwo = Gig::factory()->create(['is_live' => false]);
        
        $this->post(route('gig.status', $gigOne));

        $this->assertTrue($gigOne->fresh()->isLive());

        $this->post(route('gig.status', $gigTwo));

        $this->assertFalse($gigTwo->fresh()->isLive());
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_it_is_not_live()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => false]);
        
        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_it_is_paused()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'is_paused' => true]);
        
        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_setlist_is_full()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'songs_limit' => 1, 'songs_limit_per_user' => 2]);
        
        $this->post(route('song-requests.store', $this->song));

        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_user_reached_its_limits()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'songs_limit_per_user' => 1]);
        
        $this->post(route('song-requests.store', $this->song));

        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function when_a_gig_is_deleted_only_the_songs_in_the_waiting_list_are_removed()
    {
        SongRequest::truncate();
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true]);

        $requestWaiting = SongRequest::factory()->create(['gig_id' => $gig->id]);
        $requestCompleted = SongRequest::factory()->create(['gig_id' => $gig->id, 'finished_at' => now()]);

        $this->assertCount(1, SongRequest::waiting()->get());
        $this->assertCount(1, SongRequest::completed()->get());

        $this->delete(route('gig.destroy', $gig));

        $this->assertCount(0, SongRequest::waiting()->get());
        $this->assertCount(1, SongRequest::completed()->get());
    }

    /** @test */
    public function a_gig_can_be_duplicated()
    {
        Admin::first()->update(['super_admin' => true]);
        $this->signIn($this->admin);

        $gig = Gig::factory()->create();

        $this->assertCount(1, Gig::all());

        $this->post(route('gig.duplicate', $gig));

        $this->assertCount(2, Gig::all());

        $this->assertNull(Gig::find(2)->date);
    }
}

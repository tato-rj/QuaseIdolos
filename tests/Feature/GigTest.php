<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, Admin, SongRequest};

class GigTest extends AppTest
{
    /** @test */
    public function users_automatically_join_a_gig_if_it_is_the_only_one_ready_on_that_day()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $gig = Gig::factory()->create();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $gig->update(['is_live' => true]);

        $this->get(route('setlists.user'));

        $this->assertTrue(auth()->user()->gig()->exists());
    }

    /** @test */
    public function users_do_not_join_a_gig_automatically_if_there_is_more_than_one_ready_on_that_day()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());

        Gig::factory()->count(2)->create();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());
    }

    /** @test */
    public function users_can_join_a_gig()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());
        
        $gigOne = Gig::factory()->create(['is_live' => true]);
        $gigTwo = Gig::factory()->create(['is_live' => true]);

        $this->patch(route('gig.join', $gigTwo));

        $this->assertTrue(auth()->user()->liveGig()->is($gigTwo));

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->liveGig()->is($gigOne));

        $this->patch(route('gig.join', $gigOne));

        $this->assertTrue(auth()->user()->liveGig()->is($gigOne));

        $this->assertFalse(auth()->user()->liveGig()->is($gigTwo));
    }

    /** @test */
    public function admins_cannot_start_a_gig_that_is_not_ready()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['scheduled_for' => null]);

        $this->post(route('gig.open', $gig));
    }

    /** @test */
    public function admins_dont_even_see_the_toggle_button_if_the_gig_is_not_ready()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        Gig::truncate();

        $gig = Gig::factory()->create(['scheduled_for' => now()->copy()->addDays(3)]);

        $this->get(route('gig.index'))->assertDontSee('Abrir');

        $this->travel(3)->days();

        $this->get(route('gig.index'))->assertSee('Abrir');
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
    public function many_gigs_can_go_live_simultaneously()
    {
        Gig::truncate();
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gigOne = Gig::factory()->create(['is_live' => false]);
        $gigTwo = Gig::factory()->create(['is_live' => false]);
        
        auth()->user()->join($gigOne);

        $this->post(route('gig.open', $gigOne));

        $this->assertTrue($gigOne->fresh()->isLive());
        $this->assertFalse($gigTwo->fresh()->isLive());

        $this->post(route('gig.open', $gigTwo));

        $this->assertTrue($gigOne->fresh()->isLive());
        $this->assertTrue($gigTwo->fresh()->isLive());
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_it_is_not_live()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => false]);
        
        auth()->user()->join($gig);

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
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_user_reached_its_limits()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'songs_limit_per_user' => 1]);
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_voting_has_ended_and_the_winner_announced()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true]);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $gig->winner()->associate(SongRequest::factory()->create(['gig_id' => $gig]))->save();
        
        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_gig_cannot_be_deleted_if_there_are_requests_waiting()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);

        $gig = Gig::factory()->create(['is_live' => true]);

        $requestWaiting = SongRequest::factory()->create(['gig_id' => $gig->id]);

        $this->delete(route('gig.destroy', $gig));

        $this->assertDatabaseHas('gigs', ['id' => $gig->id]);

        $requestWaiting->finish();

        $this->delete(route('gig.destroy', $gig));

        $this->assertDatabaseMissing('gigs', ['id' => $gig->id]);
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
    }

    /** @test */
    public function all_participants_leave_when_a_gig_is_deleted()
    {
        Admin::first()->update(['super_admin' => true]);

        $this->signIn($this->admin);
        
        $gig = Gig::factory()->create(['is_live' => true]);

        auth()->user()->join($gig);

        $this->assertDatabaseHas('participants', ['user_id' => auth()->user()->id]);

        $this->delete(route('gig.destroy', $gig));

        $this->assertDatabaseMissing('participants', ['user_id' => auth()->user()->id]);
    }

    /** @test */
    public function all_participants_leave_when_a_gig_is_turned_off()
    {
        Gig::truncate();
     
        Admin::first()->update(['super_admin' => true]);

        $this->signIn();
        
        $user = auth()->user();

        $gig = Gig::factory()->create(['is_live' => true]);

        auth()->user()->join($gig);

        $this->assertTrue($gig->participants()->exists());

        $this->signIn($this->admin);

        $this->assertTrue($gig->fresh()->isLive());

        $this->post(route('gig.close', $gig));

        $this->assertFalse($gig->fresh()->isLive());

        $this->assertFalse($gig->participants()->exists());
    }

    /** @test */
    public function a_gig_accepts_infinite_repeated_requests_with_an_unset_limit()
    {
        $this->expectNotToPerformAssertions();

        $gig = Gig::factory()->create([
            'is_live' => true,
            'repeat_limit' => null
        ]);

        $this->signIn();

        auth()->user()->join($gig);

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();

        auth()->user()->join($gig);

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();
        
        auth()->user()->join($gig);

        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_accepts_repeated_requests_up_to_the_limit()
    {
        $this->expectNotToPerformAssertions();

        $gig = Gig::factory()->create([
            'is_live' => true,
            'repeat_limit' => 2
        ]);

        $this->signIn();

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();

        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_denies_repeated_requests_beyond_the_limit()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $gig = Gig::factory()->create([
            'is_live' => true,
            'repeat_limit' => 1
        ]);

        $this->signIn();

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();

        $this->post(route('song-requests.store', $this->song));
    }
}

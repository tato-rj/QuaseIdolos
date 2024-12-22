<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, Song, SongRequest, Participant, User};

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

        $this->get(route('cardapio.index'));

        $this->assertTrue(auth()->user()->gig()->exists());
    }

    /** @test */
    public function guests_do_not_automatically_join_a_gig_if_it_is_in_test_mode()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $gig = Gig::factory()->sandbox()->create();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $gig->update(['is_live' => true]);

        $this->get(route('setlists.user'));

        $this->assertFalse(auth()->user()->gig()->exists());
    }

    /** @test */
    public function users_do_not_join_a_gig_automatically_if_there_is_more_than_one_ready_on_that_day()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('setlists.user'));

        $this->assertFalse(auth()->user()->gig()->exists());

        Gig::factory()->count(2)->create();

        $this->get(route('setlists.user'));

        $this->assertFalse(auth()->user()->gig()->exists());
    }

    /** @test */
    public function users_join_a_gig_automatically_if_one_is_live_but_others_already_finished()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('cardapio.index'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $closedGig = Gig::factory()->create();

        $closedGig->update(['is_live' => true]);

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $closedGig));

        $this->signIn();

        $newGig = Gig::factory()->create();

        $newGig->update(['is_live' => true]);

        $this->get(route('cardapio.index'));

        $this->assertTrue(auth()->user()->gig()->exists());
    }

    /** @test */
    public function users_do_not_join_a_gig_automatically_if_they_are_already_in_one()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('cardapio.search'));

        $this->assertFalse(auth()->user()->gig()->exists());

        $gig = Gig::factory()->live()->create();

        auth()->user()->join($gig);

        SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $gig]);

        $this->assertTrue(auth()->user()->songRequests()->exists());

        $this->get(route('cardapio.search'));

        $this->assertTrue(auth()->user()->songRequests()->exists());
    }

    /** @test */
    public function guests_do_not_see_test_events_in_the_select_gigs_page()
    {
        Gig::truncate();

        $this->signIn();

        $publicGig = Gig::factory()->create(['name' => 'PublicEvent']);
        $testGig = Gig::factory()->sandbox()->create(['name' => 'TestEvent']);

        $this->get(route('gig.select'))
             ->assertSee($publicGig->name)
             ->assertDontSee($testGig->name);
    }

    /** @test */
    public function users_can_join_a_gig()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());
        
        $gigOne = Gig::factory()->live()->create();
        $gigTwo = Gig::factory()->live()->create();

        $this->patch(route('gig.join', $gigTwo));

        $this->assertTrue(auth()->user()->gig()->live()->first()->is($gigTwo));

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->live()->first()->is($gigOne));

        $this->patch(route('gig.join', $gigOne));

        $this->assertTrue(auth()->user()->gig()->live()->first()->is($gigOne));

        $this->assertFalse(auth()->user()->gig()->live()->first()->is($gigTwo));
    }

    /** @test */
    public function users_can_leave_a_gig()
    {
        Gig::truncate();

        $this->signIn();

        $this->get(route('home'));

        $this->assertFalse(auth()->user()->gig()->exists());
        
        $gig = Gig::factory()->live()->create();

        $this->patch(route('gig.join', $gig));

        $this->assertTrue(auth()->user()->gig()->exists());

        $this->patch(route('gig.leave', $gig));

        $this->assertFalse(auth()->user()->gig()->exists());
    }

    /** @test */
    public function when_a_user_switches_gigs_the_participation_record_is_removed_if_unconfirmed()
    {
        Gig::truncate();

        $gigOne = Gig::factory()->live()->create();
        $gigTwo = Gig::factory()->live()->create();
        $gigThree = Gig::factory()->live()->create();

        $user = $this->signIn(User::factory()->create(['name' => 'Joe']));
        
        auth()->user()->join($gigOne);

        $this->assertTrue($gigOne->participants()->by(auth()->user())->exists());
        $this->assertFalse($gigTwo->participants()->by(auth()->user())->exists());

        auth()->user()->join($gigTwo);

        $this->assertFalse($gigOne->participants()->by(auth()->user())->exists());
        $this->assertTrue($gigTwo->participants()->by(auth()->user())->exists());

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $gigTwo));

        $this->signIn($user);

        auth()->user()->join($gigThree);

        $this->assertTrue($gigTwo->participants()->by(auth()->user())->exists());
        $this->assertTrue($gigThree->participants()->by(auth()->user())->exists());
    }

    /** @test */
    public function admins_cannot_start_a_gig_that_is_not_ready()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn($this->superAdmin);

        $gig = Gig::factory()->create(['scheduled_for' => null]);

        $this->post(route('gig.open', $gig));
    }

    /** @test */
    public function admins_dont_even_see_the_toggle_button_if_the_gig_is_not_ready()
    {
        $this->signIn($this->superAdmin);

        Gig::truncate();

        $gig = Gig::factory()->create(['scheduled_for' => now()->copy()->addDays(3)]);

        $this->get(route('gig.index'))->assertDontSee('Abrir');

        $this->travel(3)->days();

        $this->get(route('gig.index'))->assertSee('Abrir');
    }

    /** @test */
    public function admins_dont_even_see_the_pause_button_if_the_gig_is_not_live()
    {
        $this->signIn($this->superAdmin);

        Gig::truncate();

        $gig = Gig::factory()->live()->create();

        $this->get(route('gig.index'))->assertSee(route('gig.pause', $gig));

        $gig->update(['is_live' => false]);

        $this->get(route('gig.index'))->assertDontSee(route('gig.pause', $gig));   
    }

    /** @test */
    public function many_gigs_can_go_live_simultaneously()
    {
        Gig::truncate();

        $this->signIn($this->superAdmin);

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

        $gig = Gig::factory()->live()->paused()->create();
        
        $this->post(route('song-requests.store', $this->song));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_user_reached_its_limits()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        Gig::factory()->create(['is_live' => true, 'songs_limit_per_user' => 1]);
        
        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_gig_will_not_accept_requests_if_the_voting_has_ended_and_the_winner_announced()
    {
        $this->expectException('App\Exceptions\SetlistException');

        $this->signIn();

        $gig = Gig::factory()->live()->create();

        $this->post(route('song-requests.store', Song::factory()->create()));

        $gig->winner()->associate(SongRequest::factory()->create(['gig_id' => $gig]))->save();
        
        $this->post(route('song-requests.store', Song::factory()->create()));
    }

    /** @test */
    public function a_gig_cannot_be_deleted_if_there_are_requests_waiting()
    {
        $this->signIn($this->superAdmin);

        $gig = Gig::factory()->live()->create();

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
        $this->signIn($this->superAdmin);

        $gig = Gig::factory()->create();

        $this->assertCount(1, Gig::all());

        $this->post(route('gig.duplicate', $gig));

        $this->assertCount(2, Gig::all());
    }

    /** @test */
    public function all_participants_leave_when_a_gig_is_deleted()
    {
        $this->signIn($this->superAdmin);
        
        $gig = Gig::factory()->live()->create();

        auth()->user()->join($gig);

        $this->assertDatabaseHas('participants', ['user_id' => auth()->user()->id]);

        $this->delete(route('gig.destroy', $gig));

        $this->assertDatabaseMissing('participants', ['user_id' => auth()->user()->id]);
    }

    /** @test */
    public function all_musicans_are_removed_when_a_gig_is_deleted()
    {
        $this->signIn($this->superAdmin);
        
        $gig = Gig::factory()->live()->create();

        $gig->musicians()->sync(User::latest()->take(3)->get()->pluck('id')->toArray());

        $this->assertDatabaseHas('gig_users', ['user_id' => User::latest()->first()->id]);

        $this->delete(route('gig.destroy', $gig));

        $this->assertDatabaseMissing('gig_users', ['user_id' => User::latest()->first()->id]);
    }

    /** @test */
    public function all_participants_records_are_confirmed_when_a_gig_is_turned_off()
    {
        Gig::truncate();

        $this->signIn();

        $gig = Gig::factory()->live()->create();

        auth()->user()->join($gig);

        $this->assertCount(0, Participant::in($gig)->confirmed()->get());
        $this->assertCount(1, Participant::in($gig)->unconfirmed()->get());

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $gig));

        $this->assertCount(2, Participant::in($gig)->confirmed()->get());
        $this->assertCount(0, Participant::in($gig)->unconfirmed()->get());

        $this->assertEmpty(auth()->user()->gig()->live()->first());
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

        $gig = Gig::factory()->live()->create([
            'repeat_limit' => 2
        ]);

        $this->signIn();

        auth()->user()->join($gig);

        $this->post(route('song-requests.store', $this->song));

        $this->signIn();

        auth()->user()->join($gig);

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

    /** @test */
    public function all_requests_in_the_waiting_list_are_removed_when_a_gig_is_closed()
    {
        $gig = Gig::factory()->live()->create();

        $this->signIn();

        auth()->user()->join($gig);

        $this->post(route('song-requests.store', Song::factory()->create()));

        $this->signIn($this->superAdmin);

        $this->assertCount(1, $gig->setlist()->get());

        $this->post(route('gig.close', $gig));

        $this->assertCount(0, $gig->setlist()->get());
    }

    /** @test */
    public function a_gig_can_require_a_password_for_guests_to_join()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $gig = Gig::factory()->live()->withPassword()->create();

        $this->signIn();

        $this->patch(route('gig.join', $gig));
    }

    /** @test */
    public function a_gig_can_verify_if_a_password_is_correct()
    {
        $this->signIn();

        $gig = Gig::factory()->live()->withPassword()->create();

        $this->post(route('gig.verify-password', $gig), ['password' => 'foo'])->assertStatus(401);

        $this->post(route('gig.verify-password', $gig), ['password' => $gig->password])->assertStatus(200);
    }
}

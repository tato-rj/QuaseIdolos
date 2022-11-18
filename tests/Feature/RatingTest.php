<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{SongRequest, Rating, User, Gig, Song};
use App\Events\ScoreSubmitted;

class RatingTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->gig = Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function guests_see_the_top_users_on_the_main_page()
    {
        $user = User::factory()->create(['name' => 'UniqueName']);

        $songRequest = SongRequest::factory()->create(['user_id' => $user->id]);

        Rating::factory()->create(['song_request_id' => $songRequest->id, 'score' => 5]);

        Rating::factory()->count(9)->create();

        $this->get(route('home'))->assertSee($user->first_name);
    }

    /** @test */
    public function an_event_is_fired_when_a_user_submits_a_score()
    {
        $this->signIn();

        auth()->user()->join($this->gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig]);

        $score = 5;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));

        \Event::assertDispatched(ScoreSubmitted::class, function ($event) {
            return $event->rating->user->is(auth()->user());
        });
    }

    /** @test */
    public function when_a_user_rates_another_user_again_the_record_is_replaced_rather_than_duplicated()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig]);

        auth()->user()->join($this->gig);

        $score = 5;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));

        $this->assertEquals(1, Rating::from(auth()->user())->count());

        $this->assertEquals(5, Rating::from(auth()->user())->first()->score);

        $score = 2;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));

        $this->assertEquals(1, Rating::from(auth()->user())->count());

        $this->assertEquals(2, Rating::from(auth()->user())->first()->score);
    }

    /** @test */
    public function users_can_choose_not_to_be_rated()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        auth()->user()->join($this->gig);

        auth()->user()->update(['has_ratings' => false]);

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $this->gig]);

        $score = 1;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));
    }

    /** @test */
    public function users_not_participating_in_ratings_dont_even_show_on_the_ratings_list()
    {
        $this->signIn();

        $userParticipating = auth()->user();

        $userNotParticipating = User::factory()->create();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        $userNotParticipating->join($gig);
        $userParticipating->join($gig);

        $songRequestNotParticipating = SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['name' => 'UniqueName']),
            'user_id' => $userNotParticipating->id, 
            'gig_id' => $gig->id, 
            'finished_at' => now()]);

        $songRequestParticipating = SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['name' => 'AnotherUser']),
            'user_id' => $userParticipating->id, 
            'gig_id' => $gig->id, 
            'finished_at' => now()]);

        $userNotParticipating->update(['has_ratings' => false]);

        $this->get(route('ratings.index'))
             ->assertDontSee($songRequestNotParticipating->song->name)
             ->assertSee($songRequestParticipating->song->name);
    }

    /** @test */
    public function a_gig_can_disable_ratings()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now(), 'has_ratings' => false]);

        auth()->user()->join($gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $gig, 'finished_at' => now()]);

        $score = 5;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));
    }

    /** @test */
    public function git_with_disabled_rating_show_nothing_on_the_ratings_list()
    {
        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now(), 'has_ratings' => false]);

        auth()->user()->join($gig);

        $song = Song::factory()->create(['name' => 'UniqueName']);

        $songRequest = SongRequest::factory()->create(['song_id' => $song, 'gig_id' => $gig, 'finished_at' => now()]);

        $this->get(route('ratings.index'))
             ->assertDontSee($songRequest->song->name);

        $gig->update(['has_ratings' => true]);

        $this->get(route('ratings.index'))
             ->assertSee($songRequest->song->name);
    }

    /** @test */
    public function admins_cannot_be_rated()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn($this->admin);
        
        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $this->gig]);

        $score = 1;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));
    }

    /** @test */
    public function admins_can_rate_other_users()
    {
        $this->expectNotToPerformAssertions();

        $this->signIn($this->admin);
        
        $songRequest = SongRequest::factory()->create(['gig_id' => $this->gig]);

        $score = 1;

        $this->post(route('ratings.store', compact(['songRequest', 'score'])));
    }

    /** @test */
    public function a_song_requested_by_an_admin_does_not_show_up_on_the_ratings_list()
    {
        $this->signIn($this->admin);

        $admin = auth()->user();

        $user = User::factory()->create();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        $admin->join($gig);
        $user->join($gig);

        $songRequestNotParticipating = SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['name' => 'UniqueName']),
            'user_id' => $admin->id, 
            'gig_id' => $gig->id, 
            'finished_at' => now()]);

        $songRequestParticipating = SongRequest::factory()->create([
            'song_id' => Song::factory()->create(['name' => 'AnotherUser']),
            'user_id' => $user->id, 
            'gig_id' => $gig->id, 
            'finished_at' => now()]);

        $this->get(route('ratings.index'))
             ->assertDontSee($songRequestNotParticipating->song->name)
             ->assertSee($songRequestParticipating->song->name);
    }

    /** @test */
    public function users_cannot_change_their_vote_more_than_three_times()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true, 'starts_at' => now()]);

        auth()->user()->join($gig);

        $songRequest = SongRequest::factory()->create(['gig_id' => $gig, 'finished_at' => now()]);

        $this->post(route('ratings.store', ['songRequest' => $songRequest, 'score' => 1]));

        $this->post(route('ratings.store', ['songRequest' => $songRequest, 'score' => 2]));

        $this->post(route('ratings.store', ['songRequest' => $songRequest, 'score' => 3]));

        $this->post(route('ratings.store', ['songRequest' => $songRequest, 'score' => 4]));
    }
}

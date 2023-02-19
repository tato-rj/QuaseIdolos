<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, SongRequest, Gig, Admin, Rating, User, Venue, SocialAccount, Participant, Invitation, Chat, BlockedUser};

class UserTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();

        $this->gig = Gig::factory()->create(['is_live' => true]);
    }

    /** @test */
    public function it_has_many_social_accounts()
    {
        auth()->user()->socialAccounts()->save(SocialAccount::factory()->make());

        $this->assertInstanceOf(SocialAccount::class, auth()->user()->socialAccounts->first());
    }

    /** @test */
    public function it_has_one_admin_account()
    {
        Admin::factory()->create(['user_id' => auth()->user()]);
        
        $this->assertInstanceOf(Admin::class, auth()->user()->admin);
    }

    /** @test */
    public function it_has_many_received_messages()
    {
        Chat::factory()->create(['to_id' => auth()->user()]);

        $this->assertInstanceOf(Chat::class, auth()->user()->receivedMessages->first());
    }

    /** @test */
    public function it_has_many_sent_messages()
    {
        Chat::factory()->create(['from_id' => auth()->user()]);

        $this->assertInstanceOf(Chat::class, auth()->user()->sentMessages->first());
    }

    /** @test */
    public function it_has_many_messages()
    {
        Chat::factory()->create(['from_id' => auth()->user()]);
        Chat::factory()->create(['to_id' => auth()->user()]);

        $this->assertInstanceOf(Chat::class, auth()->user()->allMessages->first());
        $this->assertTrue(auth()->user()->allMessages->first()->from->is(auth()->user()));
        $this->assertTrue(auth()->user()->allMessages->last()->to->is(auth()->user()));
        $this->assertCount(2, auth()->user()->allMessages);
    }

    /** @test */
    public function it_has_many_participation_records()
    {
        Participant::factory()->create(['user_id' => auth()->user()]);

        $this->assertInstanceOf(Participant::class, auth()->user()->participations->first());
    }

    /** @test */
    public function it_has_many_favorites()
    {
        auth()->user()->favorites()->save($this->song);

        $this->assertInstanceOf(Song::class, auth()->user()->favorites->first());
    }

    /** @test */
    public function it_has_many_song_requests()
    {
        (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->assertInstanceOf(SongRequest::class, auth()->user()->songRequests->first());
    }

    /** @test */
    public function it_participates_as_a_guest_in_many_song_requests()
    {
        Invitation::factory()->create(['user_id' => auth()->user()]);

        $this->assertInstanceOf(Invitation::class, auth()->user()->invitations->first());
    }

    /** @test */
    public function it_has_many_victories()
    {
        $gig = Gig::factory()->live()->create();
        
        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $gig]);
        
        $gig->update(['winner_id' => $songRequest->id]);

        $this->assertInstanceOf(SongRequest::class, auth()->user()->songRequests()->has('winners')->first());
    }

    /** @test */
    public function it_knows_if_a_specific_song_was_a_winner()
    {
        $gig = Gig::factory()->live()->create();
        
        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user(), 'gig_id' => $gig]);
 
        $this->assertFalse(auth()->user()->songRequests->first()->has('winners')->exists());

        $gig->update(['winner_id' => $songRequest->id]);

        $this->assertTrue(auth()->user()->songRequests->first()->has('winners')->exists());
    }

    /** @test */
    public function it_has_many_blocked_users()
    {
        BlockedUser::factory()->create(['by_id' => auth()->user()]);

        $this->assertInstanceOf(BlockedUser::class, auth()->user()->blocked()->first());
    }

    /** @test */
    public function it_receives_many_ratings()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()]);

        Rating::factory()->create(['song_request_id' => $songRequest]);

        $this->assertInstanceOf(Rating::class, auth()->user()->ratings->first());
    }

    /** @test */
    public function it_gives_many_ratings()
    {
        $this->signIn();

        Rating::factory()->create(['user_id' => auth()->user()]);

        $this->assertInstanceOf(Rating::class, auth()->user()->ratingsGiven->first());
    }

    /** @test */
    public function it_knows_how_to_rate_another_user()
    {
        $this->signIn();

        $otherUser = User::factory()->create();

        $songRequest = SongRequest::factory()->create(['user_id' => $otherUser]);

        $this->assertFalse(Rating::to($otherUser)->exists());
        $this->assertFalse(Rating::from(auth()->user())->exists());

        auth()->user()->rate($songRequest, 4);

        $this->assertTrue(Rating::to($otherUser)->exists());
        $this->assertTrue(Rating::from(auth()->user())->exists());
    }

    /** @test */
    public function it_knows_its_ratings_for_a_given_song_request()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()]);

        auth()->user()->rate($songRequest, 4);

        $this->assertEquals(4, auth()->user()->ratingFor($songRequest));
    }

    /** @test */
    public function it_knows_how_to_enter_a_gig()
    {
        $this->assertFalse(auth()->user()->gig()->exists());

        auth()->user()->join(Gig::factory()->create(['is_live' => true]));

        $this->assertInstanceOf(Gig::class, auth()->user()->gig->first());
    }

    /** @test */
    public function if_it_joins_a_second_gig_it_automatically_swaps_between_the_two()
    {
        auth()->user()->join($this->gig);

        $this->assertCount(1, auth()->user()->gig);
        
        $this->assertTrue($this->gig->is(auth()->user()->fresh()->gig->first()));

        auth()->user()->join(Gig::factory()->create());

        $this->assertCount(1, auth()->user()->fresh()->gig);

        $this->assertFalse($this->gig->is(auth()->user()->fresh()->gig->first()));
    }

    /** @test */
    public function it_knows_if_it_is_an_admin()
    {
        $this->assertFalse(auth()->user()->admin()->exists());

        auth()->user()->admin()->create();

        $this->assertTrue(auth()->user()->fresh()->admin()->exists());
    }

    /** @test */
    public function it_knows_if_it_has_favorited_a_song()
    {
        $this->assertFalse(auth()->user()->favorited(Song::factory()->create()));

        $song = $this->song;

        auth()->user()->favorites()->save($song);

        $this->assertTrue(auth()->user()->fresh()->favorited($song));
    }

    /** @test */
    public function it_knows_if_it_has_sung_a_song()
    {
        $this->assertFalse(auth()->user()->sung($this->song));

        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->assertFalse(auth()->user()->sung($this->song));

        $songRequest->finish();

        $this->assertTrue(auth()->user()->sung($this->song));
    }

    /** @test */
    public function it_knows_if_it_has_sung_a_song_in_a_given_gig_within_the_last_12_hours()
    {
        $this->assertFalse(auth()->user()->requestedTonight($this->song));

        auth()->user()->join($this->gig);

        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, auth()->user()->gig()->live()->first());

        $this->assertTrue(auth()->user()->requestedTonight($this->song));
    }

    /** @test */
    public function it_knows_all_the_songs_it_is_waiting_to_sing()
    {
        $songRequest = (new SongRequest)->add(auth()->user(), $this->song, $this->gig);

        $this->assertInstanceOf(SongRequest::class, auth()->user()->requestsWaiting()->first());
    }

    /** @test */
    public function it_knows_all_the_songs_it_is_has_sung()
    {
        (new SongRequest)->add(auth()->user(), $this->song, $this->gig)->finish();
        
        $this->assertInstanceOf(SongRequest::class, auth()->user()->requestsSung()->first());
    }

    /** @test */
    public function it_knows_its_coordinates()
    {
        $this->assertNotNull(auth()->user()->coordinates()->lat);
        $this->assertNotNull(auth()->user()->coordinates()->lon);
    }

    /** @test */
    public function it_knows_if_it_is_in_the_same_location_of_a_gig_or_not()
    {
        request()->server->add(['REMOTE_ADDR' => '69.142.144.48']);

        $location = geoip()->getLocation(request()->ip());

        $closeGig = Gig::factory()->create([
            'venue_id' => Venue::factory()->create(['lat' => $location->lat - .001, 'lon' => $location->lon - .001])
                ]);
        $distantGig = Gig::factory()->create([
            'venue_id' => Venue::factory()->create(['lat' => $location->lat - .002, 'lon' => $location->lat - .002])
                ]);

        $this->assertFalse(auth()->user()->isLikelyInside($distantGig));

        $this->assertTrue(auth()->user()->isLikelyInside($closeGig));
    }
}


<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{User, SongRequest, Song, Gig, Favorite, Rating, SocialAccount, Suggestion, Participant};

class UserTest extends AppTest
{
    /** @test */
    public function users_can_only_update_their_own_accounts()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        $anotherUser = User::factory()->create();

        $this->patch(route('profile.update', $anotherUser), ['name' => 'John Doe', 'email' => 'doe@emai.com']);
    }

    /** @test */
    public function when_a_user_is_deleted_the_ratings_are_also_removed()
    {
        $user = $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()->id]);

        Rating::factory()->create(['user_id' => auth()->user()->id]);

        Rating::factory()->create(['song_request_id' => $songRequest->id]);

        $this->assertCount(1, auth()->user()->ratings);

        $this->assertCount(1, auth()->user()->ratingsGiven);

        $this->delete(route('profile.destroy'));

        $this->assertEquals(0, Rating::count());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_the_admin_association_is_also_removed()
    {
        $user = $this->signIn();

        $user->admin()->create();

        $this->assertDatabaseHas('admins', ['user_id' => $user->id]);

        $this->delete(route('profile.destroy'));

        $this->assertDatabaseMissing('admins', ['user_id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_the_social_accounts_are_also_removed()
    {
        $user = $this->signIn();

        auth()->user()->socialAccounts()->save(SocialAccount::factory()->make());

        $this->assertCount(1, auth()->user()->socialAccounts);

        $this->delete(route('profile.destroy'));

        $this->assertEquals(0, SocialAccount::count());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_the_song_requests_are_also_removed()
    {
        $this->signIn();

        $gig = Gig::factory()->live()->create();

        (new SongRequest)->add(auth()->user(), $this->song, $gig);

        $user = auth()->user();

        $this->assertCount(1, SongRequest::all());

        $this->delete(route('profile.destroy'));

        $this->assertCount(0, SongRequest::all());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_any_ratings_other_users_have_for_songs_that_user_sung_are_removed()
    {
        $this->signIn();

        $songRequest = SongRequest::factory()->create(['user_id' => auth()->user()->id]);

        $otherUser = User::factory()->create();

        Rating::factory()->create([
            'song_request_id' => $songRequest,
            'user_id' => $otherUser
        ]);

        $this->assertCount(1, $otherUser->ratingsGiven()->get());

        $this->delete(route('profile.destroy'));

        $this->assertCount(0, $otherUser->ratingsGiven()->get());
    }

    /** @test */
    public function when_a_user_is_deleted_the_favorites_are_also_removed()
    {
        $this->signIn();

        auth()->user()->favorites()->save($this->song);

        $user = auth()->user();

        $this->assertCount(1, Favorite::all());

        $this->delete(route('profile.destroy'));

        $this->assertCount(0, Favorite::all());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_its_suggestions_are_removed()
    {
        $this->signIn();

        $user = auth()->user();

        Suggestion::factory()->create(['user_id' => $user]);

        $this->assertDatabaseHas('suggestions', ['user_id' => $user->id]);

        $this->delete(route('profile.destroy'));

        $this->assertDatabaseMissing('suggestions', ['user_id' => $user->id]);
    }

    /** @test */
    public function when_a_user_is_deleted_its_participant_records_are_removed()
    {
        $this->signIn();

        $user = auth()->user();

        Participant::factory()->create(['user_id' => $user]);

        $this->assertDatabaseHas('participants', ['user_id' => $user->id]);

        $this->delete(route('profile.destroy'));

        $this->assertDatabaseMissing('participants', ['user_id' => $user->id]);
    }
}

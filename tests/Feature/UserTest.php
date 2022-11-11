<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{User, SongRequest, Song, Gig, Favorite, Rating};

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
    public function when_a_user_is_deleted_the_song_request_records_remain_but_not_the_favorites()
    {
        $this->signIn();

        $gig = Gig::factory()->create(['is_live' => true]);

        (new SongRequest)->add(auth()->user(), $this->song, $gig);

        auth()->user()->favorites()->save($this->song);

        $user = auth()->user();

        $this->assertCount(1, SongRequest::all());

        $this->assertCount(1, Favorite::all());

        $this->delete(route('profile.destroy'));

        $this->assertCount(1, SongRequest::all());

        $this->assertCount(0, Favorite::all());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

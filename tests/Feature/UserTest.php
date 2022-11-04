<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{User, SongRequest, Song, Gig, Favorite};

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
    public function when_a_user_is_deleted_the_song_request_records_and_favorites_remain()
    {
        $this->signIn();

        Gig::factory()->create(['is_live' => true]);

        (new SongRequest)->add(auth()->user(), $this->song, liveGig());

        auth()->user()->favorites()->save($this->song);

        $user = auth()->user();

        $this->assertCount(1, SongRequest::all());

        $this->assertCount(1, Favorite::all());

        $this->delete(route('profile.destroy'));

        $this->assertCount(1, SongRequest::all());

        $this->assertCount(1, Favorite::all());

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

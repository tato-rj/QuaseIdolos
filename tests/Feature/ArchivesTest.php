<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Gig, SongRequest, Rating};

class ArchivesTest extends AppTest
{
    /** @test */
    public function the_list_of_participants_is_stored_on_redis_once_the_gig_is_closed()
    {
        Gig::truncate();

        $gig = Gig::factory()->live()->create();

        $this->assertRedisEmpty();

        $user = $this->signIn();

        auth()->user()->join($gig);

        $this->assertCount(0, $gig->archives()->get('participants'));

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $gig));

        $this->assertCount(1, $gig->archives()->get('participants'));

        $this->assertRedisHas('gig:'.$gig->id.':participants');
        $this->assertRedisHas('user:'.$user->id.':gigs');
    }

    /** @test */
    public function all_confirmed_song_requests_are_stored_on_redis_once_the_gig_is_closed()
    {
        Gig::truncate();

        $gig = Gig::factory()->live()->create();

        $this->assertRedisEmpty();

        $user = $this->signIn();

        $user->join($gig);

        SongRequest::factory()->create(['gig_id' => $gig, 'user_id' => $user->id]);
        $songRequest = SongRequest::factory()->finished()->create(['gig_id' => $gig, 'user_id' => $user->id]);

        $this->assertCount(0, $gig->archives()->get('setlist'));

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $gig));

        $this->assertCount(1, $gig->archives()->get('setlist'));

        $this->assertRedisHas('gig:'.$gig->id.':setlist');
        $this->assertRedisHas('user:'.$user->id.':songRequests');
        $this->assertRedisHas('song:'.$songRequest->song->id.':songRequests');
    }

    /** @test */
    public function all_ratings_are_stored_on_redis_once_the_gig_is_closed()
    {
        Gig::truncate();

        $gig = Gig::factory()->live()->create();

        $this->assertRedisEmpty();

        $user = $this->signIn();

        $user->join($gig);

        $songRequest = SongRequest::factory()->finished()->create(['gig_id' => $gig, 'user_id' => $user]);
        Rating::factory()->create(['song_request_id' => $songRequest]);
        Rating::factory()->create(['song_request_id' => $songRequest]);

        $this->assertCount(0, $gig->archives()->get('ratings'));

        $this->signIn($this->superAdmin);

        $this->post(route('gig.close', $gig));

        $this->assertCount(2, $gig->archives()->get('ratings'));

        $this->assertRedisHas('gig:'.$gig->id.':ratings');
        $this->assertRedisHas('gig:'.$gig->id.':winner');
        $this->assertRedisHas('user:'.$user->id.':ratings');
        $this->assertRedisHas('song:'.$songRequest->song->id.':ratings');
    }
}

<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Show, Song, Setlist, User};

class ShowTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $this->show = Show::factory()->create();
    }

    /** @test */
    public function an_admin_can_add_or_remove_a_song_from_the_setlist()
    {
        $this->signIn($this->superAdmin);

        $song = Song::factory()->create();

        $this->assertCount(0, $this->show->setlist()->get());

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $song]));

        $this->assertCount(1, $this->show->setlist()->get());

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $song]));

        $this->assertCount(0, $this->show->setlist()->get());
    }

    /** @test */
    public function the_order_of_a_new_song_is_automatically_set()
    {
        $this->signIn($this->superAdmin);

        $songNotIntended = Song::factory()->create();

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $songNotIntended]));

        $this->assertEquals(1, $this->show->setlist()->get()->last()->orderForHumans);

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => Song::factory()->create()]));

        $this->assertEquals(2, $this->show->setlist()->get()->last()->orderForHumans);

        $this->post(route('shows.update-setlist', ['show' => $this->show, 'song' => $songNotIntended]));

        $this->assertEquals(1, $this->show->setlist()->get()->last()->orderForHumans);
    }

    /** @test */
    public function all_musicans_are_removed_when_a_show_is_deleted()
    {
        $this->signIn($this->superAdmin);

        $this->show->musicians()->sync(User::latest()->take(3)->get()->pluck('id')->toArray());

        $this->assertDatabaseHas('show_users', ['user_id' => User::latest()->first()->id]);

        $this->delete(route('shows.destroy', $this->show));

        $this->assertDatabaseMissing('show_users', ['user_id' => User::latest()->first()->id]);
    }

    /** @test */
    public function all_songs_in_the_setlist_are_removed_when_a_show_is_deleted()
    {
        $this->signIn($this->superAdmin);

        $song = Song::factory()->create();

        (new Setlist)->toggle($this->show, $song);

        $this->assertDatabaseHas('setlists', ['song_id' => $song->id]);

        $this->delete(route('shows.destroy', $this->show));

        $this->assertDatabaseMissing('setlists', ['song_id' => $song->id]);
    }
}

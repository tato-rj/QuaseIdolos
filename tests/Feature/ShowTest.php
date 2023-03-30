<?php

namespace Tests\Feature;

use Tests\AppTest;
use App\Models\{Show, Song, Setlist, User, Gig, Venue};

class ShowTest extends AppTest
{
    public function setUp() : void
    {
        parent::setUp();

        $venue = Venue::factory()->create(['name' => 'VenueUniqueName']);

        $this->show = Show::factory()->live()->create(['venue_id' => $venue]);
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

        $this->assertDatabaseHas('show_user', ['user_id' => User::latest()->first()->id]);

        $this->delete(route('shows.destroy', $this->show));

        $this->assertDatabaseMissing('show_user', ['user_id' => User::latest()->first()->id]);
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

    /** @test */
    public function a_show_does_not_appear_in_the_gigs_list_for_users()
    {
        $this->signIn();

        $gigA = Gig::factory()->live()->create();

        $gigB = Gig::factory()->live()->create();

        $this->get(route('gig.select'))
             ->assertSee([$gigA->venue->name, $gigB->venue->name])
             ->assertDontSee($this->show->venue->name);
    }

    /** @test */
    public function admins_in_the_musicians_list_for_a_show_automatically_join_the_event()
    {
        $this->signIn($this->admin);

        $this->show->musicians()->attach($this->admin->id);

        $this->get(route('setlists.admin'));

        $this->assertNotNull(auth()->user()->liveGig);

        $this->assertTrue(auth()->user()->liveGig->is($this->show));
    }

    /** @test */
    public function admins_not_in_the_musicians_list_for_a_show_dont_join_the_event()
    {
        $this->signIn($this->admin);

        $this->get(route('setlists.admin'));

        $this->assertNull(auth()->user()->liveGig);
    }

    /** @test */
    public function admins_in_the_musicians_list_for_a_show_join_even_if_other_kareokes_are_live()
    {
        $this->signIn($this->admin);

        $this->show->musicians()->attach($this->admin->id);

        Gig::factory()->live()->create();

        $this->get(route('setlists.admin'));

        $this->assertTrue(auth()->user()->liveGig->is($this->show));
    }

    /** @test */
    public function admins_can_turn_a_show_on_and_off()
    {
        $this->signIn($this->superAdmin);

        Show::truncate();

        $show = Show::factory()->create();

        $this->assertFalse(Show::ready()->live()->exists());

        $this->post(route('shows.open', $show));

        $this->assertTrue(Show::ready()->live()->exists());

        $this->post(route('shows.close', $show));

        $this->assertFalse(Show::ready()->live()->exists());
    }
}

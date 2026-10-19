<?php

namespace Tests\Feature;

use App\Events\SongFinished;
use App\Exceptions\SetlistException;
use App\Http\Controllers\SongRequestsController;
use App\Http\Requests\SongRequestForm;
use App\Models\{Admin, Gig, Set, Song, SongRequest, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\AppTest;

class LiveCardapioTest extends AppTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->gig = Gig::factory()->live()->create();
    }

    /** @test */
    public function another_users_request_cannot_be_changed()
    {
        $this->signIn()->join($this->gig);
        $other = SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        $this->withExceptionHandling()->patchJson(route('song-requests.update', $other), [
            'new_song_id' => $this->song->id,
        ])->assertForbidden();

        $this->assertEquals($other->song_id, $other->fresh()->song_id);
    }

    /** @test */
    public function invalid_change_input_returns_validation_errors_instead_of_a_server_error()
    {
        $user = $this->signIn();
        $user->join($this->gig);
        $entry = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $user->id]);

        $this->withExceptionHandling()->patchJson(route('song-requests.update', $entry), [
            'new_song_id' => 999999,
        ])->assertUnprocessable()->assertJsonValidationErrors('new_song_id');
    }

    /** @test */
    public function a_completed_request_cannot_be_changed()
    {
        $this->signIn($this->admin)->join($this->gig);
        $entry = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'finished_at' => now()]);
        $this->expectException(SetlistException::class);
        $this->patch(route('song-requests.update', $entry), ['new_song_id' => $this->song->id]);
    }

    /** @test */
    public function changing_to_a_song_unknown_by_the_band_is_rejected()
    {
        $user = $this->signIn();
        $user->join($this->gig);
        $musician = Admin::factory()->musician()->create(['unknown_songs' => [$this->song->id]]);
        $this->gig->musicians()->attach($musician->user_id);
        $entry = SongRequest::factory()->create(['gig_id' => $this->gig->id, 'user_id' => $user->id]);

        $this->expectException(SetlistException::class);
        $this->patch(route('song-requests.update', $entry), ['new_song_id' => $this->song->id]);
    }

    /** @test */
    public function completing_twice_does_not_change_the_queue_twice_or_broadcast_twice()
    {
        $this->signIn($this->admin)->join($this->gig);
        $this->gig->update(['set_limit' => 3]);
        Set::new($this->gig);
        $first = (new SongRequest)->add($this->admin, $this->song, $this->gig);
        (new SongRequest)->add($this->admin, $this->song, $this->gig);

        $this->post(route('song-requests.finish', $first));
        $this->post(route('song-requests.finish', $first));

        $this->assertEquals(1, $this->gig->sets()->first()->queue);
        $this->assertEquals(1, $this->gig->sets()->first()->songs_left);
        \Event::assertDispatchedTimes(SongFinished::class, 1);
    }

    /** @test */
    public function requests_and_cancellations_work_without_a_set()
    {
        $user = $this->signIn();
        $user->join($this->gig);
        $this->post(route('song-requests.store', $this->song))->assertRedirect();
        $entry = $user->songRequests()->first();
        $this->delete(route('song-requests.cancel', $entry))->assertRedirect();
        $this->assertDatabaseMissing('song_requests', ['id' => $entry->id]);
    }

    /** @test */
    public function capacity_is_rechecked_after_a_form_was_previously_authorized()
    {
        $user = $this->signIn();
        $user->join($this->gig);
        $this->gig->update(['songs_limit' => 1]);
        $user->checkLiveGig();

        $route = clone app('router')->getRoutes()->getByName('song-requests.store');
        $route->bind(Request::create(route('song-requests.store', $this->song), 'POST'));
        $route->setParameter('song', $this->song);
        $form = new SongRequestForm();
        $form->setRouteResolver(function () use ($route) { return $route; });
        $this->assertTrue($form->authorize());

        // Represents a competing submission committed before the lock is acquired.
        SongRequest::factory()->create(['gig_id' => $this->gig->id]);

        try {
            (new SongRequestsController)->store(Request::create('/', 'POST'), $this->song, $form);
            $this->fail('A stale approval bypassed the event limit.');
        } catch (SetlistException $e) {
            $this->assertEquals(1, $this->gig->setlist()->count());
        }
    }

    /** @test */
    public function event_transaction_rolls_back_requests_and_counters_together()
    {
        $this->gig->update(['set_limit' => 3]);
        Set::new($this->gig);

        try {
            $this->gig->withSetlistLock(function ($gig) {
                (new SongRequest)->add($this->admin, $this->song, $gig);
                throw new \RuntimeException('simulated failure');
            });
        } catch (\RuntimeException $e) {
            $this->assertEquals('simulated failure', $e->getMessage());
        }

        $this->assertEquals(0, $this->gig->setlist()->count());
        $this->assertEquals(0, $this->gig->sets()->first()->queue);
        $this->assertEquals(3, $this->gig->sets()->first()->songs_left);
    }

    /** @test */
    public function reorder_cannot_modify_a_request_in_another_event()
    {
        $this->signIn($this->admin)->join($this->gig);
        $other = SongRequest::factory()->create(['order' => 5]);

        $this->withExceptionHandling()->getJson(route('setlists.table', [
            'newOrder' => [['id' => $other->id, 'order' => 0]],
        ]))->assertUnprocessable();

        $this->assertEquals(5, $other->fresh()->order);
    }

    /** @test */
    public function reorder_accepts_the_existing_json_string_payload()
    {
        $this->signIn($this->admin)->join($this->gig);
        $entries = SongRequest::factory()->count(2)->create(['gig_id' => $this->gig->id]);
        $order = [
            json_encode(['id' => $entries[0]->id, 'order' => 1]),
            json_encode(['id' => $entries[1]->id, 'order' => 0]),
        ];
        $this->get(route('setlists.table', ['newOrder' => $order]))->assertOk();
        $this->assertEquals(1, $entries[0]->fresh()->order);
        $this->assertEquals(0, $entries[1]->fresh()->order);
    }

    /** @test */
    public function search_cannot_render_arbitrary_internal_views()
    {
        $this->withExceptionHandling()->getJson(route('cardapio.search', [
            'input' => 'test', 'table' => 'pages.users.index',
        ]))->assertUnprocessable();
    }

    /** @test */
    public function false_pagination_keeps_the_full_change_song_result_set()
    {
        Song::factory()->count(15)->create(['name' => 'Matching song']);
        $this->get(route('cardapio.search', ['input' => 'Matching', 'paginate' => 'false']))
            ->assertSee('15 músicas');
    }

    /** @test */
    public function the_modal_reflects_edits()
    {
        $this->get(route('cardapio.modal', $this->song))->assertOk();
        $this->song->update(['lyrics' => 'Freshly updated lyrics']);
        $this->get(route('cardapio.modal', $this->song))->assertSee('Freshly updated lyrics');
    }

    /** @test */
    public function a_missing_song_modal_uses_the_standard_not_found_response()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->get(route('cardapio.modal', 999999));
    }

    /** @test */
    public function setlist_refresh_query_count_stays_bounded_as_the_queue_grows()
    {
        $this->signIn($this->admin)->join($this->gig);
        SongRequest::factory()->count(2)->create(['gig_id' => $this->gig->id]);
        DB::enableQueryLog();
        $this->get(route('setlists.table'))->assertOk();
        $small = count(DB::getQueryLog());

        SongRequest::factory()->count(10)->create(['gig_id' => $this->gig->id]);
        DB::flushQueryLog();
        $this->get(route('setlists.table'))->assertOk();
        $large = count(DB::getQueryLog());
        DB::disableQueryLog();

        $this->assertLessThanOrEqual($small + 2, $large, 'Queue rows must not introduce per-row SQL queries.');
    }
}

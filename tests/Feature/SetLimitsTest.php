<?php

namespace Tests\Feature;

use App\Models\{Gig, Set, SongRequest};
use Tests\AppTest;

class SetLimitsTest extends AppTest
{
    public function setUp(): void
    {
        parent::setUp();

        $this->gig = Gig::factory()->live()->create(['set_limit' => 4]);
        $this->signIn($this->superAdmin)->join($this->gig);
    }

    /** @test */
    public function changing_the_current_limit_keeps_confirmed_songs_in_the_current_set_total()
    {
        Set::new($this->gig);

        // Completed songs from an earlier set must not be counted again.
        foreach ($this->addRequests(4) as $entry)
            $this->post(route('song-requests.finish', $entry))->assertRedirect();

        $entries = $this->addRequests(3);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(5);

        $this->assertSetState(5, 2, 2, false);
        $this->assertEquals(5, $this->gig->setlist()->completed()->count());
    }

    /** @test */
    public function increasing_a_full_sets_limit_reopens_its_available_slots()
    {
        $this->changeLimit(2);
        $entries = $this->addRequests(2);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(4);

        $this->assertSetState(4, 2, 1, false);

        $guest = $this->signIn();
        $guest->join($this->gig);
        $this->post(route('song-requests.store', $this->song))->assertRedirect();
        $this->assertSetState(4, 1, 2, false);
    }

    /** @test */
    public function lowering_the_limit_keeps_existing_requests_and_reopens_only_after_enough_cancellations()
    {
        Set::new($this->gig);
        $entries = $this->addRequests(3);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(2);

        $this->assertSetState(2, -1, 2, true);
        $this->assertEquals(3, $this->gig->setlist()->count());

        $this->delete(route('song-requests.cancel', $entries[1]))->assertRedirect();
        $this->assertSetState(2, 0, 1, true);

        $this->delete(route('song-requests.cancel', $entries[2]))->assertRedirect();
        $this->assertSetState(2, 1, 0, false);
    }

    /** @test */
    public function a_deferred_limit_takes_effect_when_the_current_set_ends()
    {
        $this->changeLimit(2);
        $entries = $this->addRequests(2);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(5, false);

        $this->assertEquals(5, $this->gig->fresh()->set_limit);
        $this->assertSetState(2, 0, 1, true);

        $this->post(route('song-requests.finish', $entries[1]))->assertRedirect();
        $this->assertSetState(5, 5, 0, false);
    }

    /** @test */
    public function enabling_sets_counts_the_waiting_list_and_cancellations_never_make_the_total_negative()
    {
        $this->gig->update(['set_limit' => null]);
        $entries = $this->addRequests(3);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(2);

        $this->assertSetState(2, 0, 2, true);

        $this->delete(route('song-requests.cancel', $entries[1]))->assertRedirect();
        $this->assertSetState(2, 1, 1, false);

        $this->delete(route('song-requests.cancel', $entries[2]))->assertRedirect();
        $this->assertSetState(2, 2, 0, false);

        // A repeated cancellation must not return the same slot twice.
        $this->delete(route('song-requests.cancel', $entries[2]))->assertRedirect();
        $this->assertSetState(2, 2, 0, false);
    }

    /** @test */
    public function re_enabling_sets_preserves_waiting_requests_without_counting_previous_confirmations()
    {
        Set::new($this->gig);
        $entries = $this->addRequests(3);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->changeLimit(null);
        $this->assertFalse($this->gig->sets()->exists());
        $this->assertEquals(3, $this->gig->setlist()->count());

        $this->changeLimit(3);
        $this->assertSetState(3, 1, 2, false);

        $this->delete(route('song-requests.cancel', $entries[1]))->assertRedirect();
        $this->assertSetState(3, 2, 1, false);
    }

    /** @test */
    public function cancelling_extra_admin_requests_keeps_the_set_closed_until_it_has_room()
    {
        $this->changeLimit(2);
        $entries = $this->addRequests(4);
        $this->post(route('song-requests.finish', $entries[0]))->assertRedirect();

        $this->delete(route('song-requests.cancel', $entries[1]))->assertRedirect();
        $this->assertSetState(2, -1, 2, true);

        $this->delete(route('song-requests.cancel', $entries[2]))->assertRedirect();
        $this->assertSetState(2, 0, 1, true);

        $this->delete(route('song-requests.cancel', $entries[3]))->assertRedirect();
        $this->assertSetState(2, 1, 0, false);
    }

    /** @test */
    public function cancellations_reconcile_legacy_sets_that_did_not_count_the_waiting_list()
    {
        $this->gig->update(['set_limit' => null]);
        $entries = $this->addRequests(2);
        $this->gig->update(['set_limit' => 2]);
        $this->gig->sets()->create(['limit' => 2, 'songs_left' => 2, 'queue' => 0, 'finished' => true]);

        $this->delete(route('song-requests.cancel', $entries[0]))->assertRedirect();
        $this->assertSetState(2, 1, 1, false);

        $this->delete(route('song-requests.cancel', $entries[1]))->assertRedirect();
        $this->assertSetState(2, 2, 0, false);
    }

    /** @test */
    public function a_limit_change_finishes_an_empty_set_that_has_already_reached_the_new_limit()
    {
        Set::new($this->gig);
        foreach ($this->addRequests(2) as $entry)
            $this->post(route('song-requests.finish', $entry))->assertRedirect();

        $this->changeLimit(2);

        $this->assertSetState(2, 2, 0, false);
        $this->assertEquals(2, $this->gig->setlist()->completed()->count());
    }

    /** @test */
    public function a_failed_limit_change_rolls_back_event_settings_and_counters_together()
    {
        Set::new($this->gig);
        $this->addRequests(2);
        Set::updating(function ($set) {
            if ($set->isDirty('limit'))
                throw new \RuntimeException('simulated set update failure');
        });

        try {
            $this->changeLimit(5);
            $this->fail('The simulated set update should fail.');
        } catch (\RuntimeException $exception) {
            $this->assertEquals('simulated set update failure', $exception->getMessage());
        }

        $this->assertEquals(4, $this->gig->fresh()->set_limit);
        $this->assertSetState(4, 2, 2, false);
    }

    private function addRequests(int $count)
    {
        return collect(range(1, $count))->map(function () {
            return (new SongRequest)->add($this->superAdmin, $this->song, $this->gig->fresh());
        });
    }

    private function changeLimit($limit, bool $now = true): void
    {
        $this->patch(route('gig.update', $this->gig), [
            'venue_id' => $this->gig->venue_id,
            'set_limit' => $limit,
            'change_set_limit_now' => $now ? 1 : 0,
            'musicians' => [],
        ])->assertRedirect()->assertSessionHasNoErrors();
    }

    private function assertSetState(int $limit, int $left, int $queue, bool $finished): void
    {
        $set = $this->gig->sets()->firstOrFail();
        $this->assertEquals($limit, $set->limit);
        $this->assertEquals($left, $set->songs_left);
        $this->assertEquals($queue, $set->queue);
        $this->assertSame($finished, $set->isFinished());
        $this->assertGreaterThanOrEqual(0, $set->limit - $set->songsLeft());
    }
}

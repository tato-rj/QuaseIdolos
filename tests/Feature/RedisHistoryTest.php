<?php

namespace Tests\Feature;

use App\Archives\{ArchiveCodec, ArchiveCompactor, RedisKeys};
use App\Cache\HistorySafeRedisStore;
use Illuminate\Support\Facades\{Cache, Redis};
use Tests\AppTest;

class RedisHistoryTest extends AppTest
{
    protected function raw()
    {
        return new RedisKeys(Redis::connection('default'));
    }

    protected function snapshot($id = 1)
    {
        return json_encode([
            'id' => $id, 'name' => 'Canção 🎵', 'finished_at' => '2023-01-11 20:00:00',
            'song' => ['lyrics' => str_repeat("A complete historical lyric\n", 500), 'artist' => ['name' => 'Historical artist']],
            'users' => [['id' => 10, 'name' => 'João'], ['id' => 20, 'name' => 'Ana']],
        ]);
    }

    /** @test */
    public function archive_readers_support_mixed_legacy_and_compressed_records_in_the_same_order()
    {
        $legacy = $this->snapshot(1);
        $key = 'song:'.$this->song->id.':songRequests';
        Redis::rpush($key, [$legacy, ArchiveCodec::encode($this->snapshot(2)), '']);

        $records = $this->song->archives()->get('songRequests');
        $this->assertEquals([json_decode($legacy), json_decode($this->snapshot(2)), null], $records->all());
        $this->assertSame(3, $this->song->archives()->count('songRequests'));
        $this->assertCount(1, $this->song->archives()->get('songRequests', 0));
    }

    /** @test */
    public function new_archives_are_compressed_without_dropping_relationships_or_fields()
    {
        $snapshot = json_decode($this->snapshot(), true);
        $this->song->archives()->set('songRequests', $snapshot);
        $stored = Redis::lindex('song:'.$this->song->id.':songRequests', 0);

        $this->assertTrue(ArchiveCodec::compressed($stored));
        $this->assertEquals($snapshot, json_decode(ArchiveCodec::decode($stored), true));

        config(['archives.compress' => false]);
        $this->song->archives()->set('songRequests', ['id' => 2]);
        $this->assertSame([2, 1], $this->song->archives()->get('songRequests')->pluck('id')->all());
    }

    /** @test */
    public function full_model_snapshots_keep_the_exact_original_json_including_loaded_relationships()
    {
        $this->song->update(['lyrics' => str_repeat('Historical lyrics with every line intact. ', 500)]);
        $entry = \App\Models\SongRequest::factory()->finished()->create(['song_id' => $this->song->id]);
        $entry->load(['song.artist', 'song.genre', 'user']);
        $before = (string) $entry;

        $this->song->archives()->saveSongRequest($entry);
        $stored = Redis::lindex('song:'.$this->song->id.':songRequests', 0);
        $this->assertSame($before, ArchiveCodec::decode($stored));
        $this->assertEquals(json_decode($before), $this->song->archives()->get('songRequests')->first());
    }

    /** @test */
    public function dry_run_never_modifies_redis_and_only_visits_owned_archive_lists()
    {
        $json = $this->snapshot();
        Redis::rpush('gig:123:setlist', [$json, $json]);
        Redis::rpush('gig:123:unrelated', [$json]);
        Redis::rpush('queues:default', [$json]);
        Redis::set('gig:124:setlist', 'not a list');
        $raw = $this->raw();
        $outside = 'other-application:gig:123:setlist';
        $raw->command(['RPUSH', $outside, $json]);

        try {
            $result = (new ArchiveCompactor($raw))->run();
            $this->assertSame(2, $result['candidates']);
            $this->assertSame(0, $result['changed']);
            $this->assertSame([$json, $json], Redis::lrange('gig:123:setlist', 0, -1));
            $this->assertSame([$json], Redis::lrange('gig:123:unrelated', 0, -1));
            $this->assertSame([$json], Redis::lrange('queues:default', 0, -1));
            $this->assertSame([$json], $raw->command(['LRANGE', $outside, 0, -1]));
            $this->assertLessThan($result['before_bytes'], $result['after_bytes']);
        } finally {
            $raw->command(['DEL', $outside]);
        }
    }

    /** @test */
    public function compaction_reduces_redis_allocation_and_preserves_duplicates_order_and_expiry()
    {
        $records = [$this->snapshot(3), $this->snapshot(2), $this->snapshot(2), '', $this->snapshot(1)];
        $key = 'gig:123:setlist';
        Redis::rpush($key, $records);
        Redis::expire($key, 3600);
        $raw = $this->raw();
        $physical = $raw->prefix().$key;
        $before = $raw->command(['MEMORY', 'USAGE', $physical]);
        $ttl = Redis::pttl($key);
        $compactor = new ArchiveCompactor($raw);
        $result = $compactor->run(true, false, 2);

        $this->assertSame(4, $result['changed']);
        $this->assertSame(5, Redis::llen($key));
        $this->assertSame($records, array_map([ArchiveCodec::class, 'decode'], Redis::lrange($key, 0, -1)));
        $this->assertGreaterThan($ttl - 5000, Redis::pttl($key));
        $this->assertLessThanOrEqual($ttl, Redis::pttl($key));
        $this->assertLessThan($before / 2, $raw->command(['MEMORY', 'USAGE', $physical]));
        $this->assertSame(0, $compactor->run(true)['changed']);

        $restored = $compactor->run(true, true, 2);
        $this->assertSame(4, $restored['changed']);
        $this->assertSame($records, Redis::lrange($key, 0, -1));
    }

    /** @test */
    public function a_concurrent_push_cannot_make_compaction_overwrite_another_event()
    {
        $before = $this->snapshot(1);
        $new = $this->snapshot(2);
        Redis::lpush('gig:123:setlist', $before);
        $raw = $this->raw();
        Redis::lpush('gig:123:setlist', $new);

        $this->assertFalse((new ArchiveCompactor($raw))->replace($raw->prefix().'gig:123:setlist', 0, $before, ArchiveCodec::encode($before)));
        $this->assertSame([$new, $before], Redis::lrange('gig:123:setlist', 0, -1));
    }

    /** @test */
    public function replacement_refuses_different_history_even_if_the_source_bytes_match()
    {
        $before = $this->snapshot(1);
        Redis::lpush('gig:123:setlist', $before);

        try {
            $raw = $this->raw();
            (new ArchiveCompactor($raw))->replace($raw->prefix().'gig:123:setlist', 0, $before, ArchiveCodec::encode($this->snapshot(2)));
            $this->fail('A replacement changed event history.');
        } catch (\RuntimeException $e) {
            $this->assertSame([$before], Redis::lrange('gig:123:setlist', 0, -1));
        }
    }

    /** @test */
    public function pushes_between_batches_preserve_the_whole_history_and_can_be_compacted_on_a_second_pass()
    {
        $records = array_map(function ($id) { return $this->snapshot($id); }, range(1, 12));
        Redis::rpush('gig:123:setlist', $records);
        $compactor = new ArchiveCompactor($this->raw());
        $pushed = false;
        $new = $this->snapshot(99);
        $compactor->run(true, false, 2, 0, function () use (&$pushed, $new) {
            if (! $pushed) {
                Redis::lpush('gig:123:setlist', ArchiveCodec::encode($new));
                $pushed = true;
            }
        });

        $expected = array_merge([$new], $records);
        $this->assertSame($expected, array_map([ArchiveCodec::class, 'decode'], Redis::lrange('gig:123:setlist', 0, -1)));
        $compactor->run(true);
        $this->assertSame($expected, array_map([ArchiveCodec::class, 'decode'], Redis::lrange('gig:123:setlist', 0, -1)));
        $this->assertSame(0, $compactor->run()['candidates']);
    }

    /** @test */
    public function an_interrupted_compaction_keeps_all_records_readable_and_can_resume()
    {
        $records = array_map(function ($id) { return $this->snapshot($id); }, range(1, 5));
        Redis::rpush('gig:123:setlist', $records);
        $compactor = new ArchiveCompactor($this->raw());

        try {
            $compactor->run(true, false, 2, 0, function () { throw new \RuntimeException('interrupted'); });
            $this->fail('The simulated interruption did not occur.');
        } catch (\RuntimeException $e) {
            $this->assertSame('interrupted', $e->getMessage());
        }

        $this->assertSame($records, array_map([ArchiveCodec::class, 'decode'], Redis::lrange('gig:123:setlist', 0, -1)));
        $this->assertSame(3, $compactor->run(true)['changed']);
        $compactor->run(true, true);
        $this->assertSame($records, Redis::lrange('gig:123:setlist', 0, -1));
    }

    /** @test */
    public function command_defaults_to_dry_run_and_accepts_only_bounded_batch_sizes()
    {
        $before = $this->snapshot();
        Redis::lpush('gig:123:setlist', $before);
        $this->artisan('redis:archives:compact', ['--pause' => 0])->assertExitCode(0);
        $this->assertSame([$before], Redis::lrange('gig:123:setlist', 0, -1));
        $this->artisan('redis:archives:compact', ['--apply' => true, '--batch' => 0])->assertExitCode(1);
        $this->artisan('redis:archives:compact', ['--apply' => true, '--pause' => -1])->assertExitCode(1);
        $this->assertSame([$before], Redis::lrange('gig:123:setlist', 0, -1));
    }

    /** @test */
    public function corrupted_values_stop_compaction_without_overwriting_them()
    {
        $damaged = ArchiveCodec::HEADER.'invalid gzip';
        Redis::rpush('gig:123:setlist', [$damaged]);
        $this->artisan('redis:archives:compact', ['--apply' => true])->assertExitCode(1);
        $this->assertSame([$damaged], Redis::lrange('gig:123:setlist', 0, -1));
    }

    /** @test */
    public function cache_clear_preserves_archives_jobs_and_other_keys_in_the_same_database()
    {
        config(['cache.stores.redis.connection' => 'default', 'cache.prefix' => 'qa-cache']);
        Cache::purge('redis');
        $cache = Cache::store('redis');
        $this->assertInstanceOf(HistorySafeRedisStore::class, $cache->getStore());
        foreach (range(1, 220) as $index)
            $cache->put('entry-'.$index, ['id' => $index], 3600);

        $history = $this->snapshot();
        Redis::rpush('gig:123:setlist', [$history]);
        Redis::rpush('queues:default', ['pending job']);
        Redis::set('session:123', 'active session');
        Redis::set('another-cache:entry', 'other application cache');
        $this->artisan('cache:clear', ['store' => 'redis'])->assertExitCode(0);

        foreach (range(1, 220) as $index)
            $this->assertNull($cache->get('entry-'.$index));
        $this->assertSame([$history], Redis::lrange('gig:123:setlist', 0, -1));
        $this->assertSame(['pending job'], Redis::lrange('queues:default', 0, -1));
        $this->assertSame('active session', Redis::get('session:123'));
        $this->assertSame('other application cache', Redis::get('another-cache:entry'));
    }

    /** @test */
    public function cache_clear_escapes_literal_glob_characters_in_its_prefix()
    {
        config(['cache.stores.redis.connection' => 'default', 'cache.prefix' => 'cache[qa]*']);
        Cache::purge('redis');
        $cache = Cache::store('redis');
        $cache->put('entry', 'cached', 3600);
        Redis::set('cacheq-other:entry', 'keep');
        $cache->flush();

        $this->assertNull($cache->get('entry'));
        $this->assertSame('keep', Redis::get('cacheq-other:entry'));
    }

    /** @test */
    public function the_scoped_cache_store_keeps_normal_cache_and_lock_behavior()
    {
        config(['cache.stores.redis.connection' => 'default', 'cache.prefix' => 'qa-cache']);
        Cache::purge('redis');
        $cache = Cache::store('redis');
        $cache->put('nested', ['artists' => ['João', 'Ana']], 60);
        $this->assertSame(['artists' => ['João', 'Ana']], $cache->get('nested'));
        $this->assertTrue($cache->add('counter', 1, 60));
        $this->assertFalse($cache->add('counter', 9, 60));
        $this->assertSame(2, $cache->increment('counter'));

        $lock = $cache->lock('event-test', 10);
        $this->assertTrue($lock->get());
        $this->assertFalse($cache->lock('event-test', 10)->get());
        $this->assertTrue($lock->release());
    }

    /** @test */
    public function dangerous_cache_prefixes_cannot_delete_event_history()
    {
        config(['cache.stores.redis.connection' => 'default', 'cache.prefix' => 'gig']);
        Cache::purge('redis');
        $history = $this->snapshot();
        Redis::rpush('gig:123:setlist', [$history]);
        Cache::store('redis')->flush();
        $this->assertSame([$history], Redis::lrange('gig:123:setlist', 0, -1));

        config(['cache.prefix' => '']);
        Cache::purge('redis');
        $this->expectException(\RuntimeException::class);
        Cache::store('redis')->flush();
    }
}

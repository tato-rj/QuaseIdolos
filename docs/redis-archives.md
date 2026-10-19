# Redis event history and memory

The application stores permanent event snapshots in Redis lists on the `default` connection:

| Namespace | Lists |
| --- | --- |
| `gig:<id>:` | `participants`, `setlist`, `ratings`, `winner` |
| `user:<id>:` | `gigs`, `songRequests`, `ratings` |
| `song:<id>:` | `songRequests`, `ratings` |

The configured Redis client prefix precedes each name. Archive snapshots contain complete model JSON, including relationships loaded when the event was archived. User and song histories can each include copies of the same song's lyrics and related data. These lists have no retention limit. Laravel cache uses its own connection/prefix; sessions and queues may also use Redis depending on deployment settings.

## Changes

Archive writes now losslessly gzip snapshots when they are at least 256 bytes and compression makes them smaller. Small/incompressible values remain unchanged. Compressed values carry a binary format/version marker; readers accept both the old JSON and the new representation in the same list. No fields, snapshots, duplicates, list positions or expiry settings are removed. Old snapshots remain valid after the source user/song/event changes or is deleted.

`redis:archives:compact` reads existing lists in bounded batches and verifies exact decompressed bytes before a Lua compare-and-set replaces each value. A concurrent push or rewrite cannot make it overwrite a different event. An interrupted run leaves a readable mixture of representations and can be rerun. SCAN may revisit keys; CLI totals describe inspected entries, not a guaranteed unique inventory. Concurrent writes can require another pass. `--limit` is a preview/inspection limit, not a saved resume cursor.

Laravel's Redis cache store is replaced by `HistorySafeRedisStore`, preserving its cache/lock APIs. Cache clearing scans only that store's literal prefix, uses bounded deletion batches and preserves event-history namespaces even if the cache and archives share a database. It refuses to clear an empty cache prefix. This protects `cache:clear` and the cache step in `optimize:clear` from the stock driver's whole-database `FLUSHDB`. It does not alter raw Redis administrative commands or external programs.

The development-only `redis:flush` command now uses the configured connection and a checked application prefix, rather than shelling out to a different Redis server/database. Its production prohibition remains in place. Do not use it for deployment or memory reduction.

## Deployment and existing data

No SQL migration, dependency upgrade, asset build or UI change is required. PHP CLI and web/worker runtimes need zlib to read compressed snapshots. Verify the deployment's existing Redis persistence and a recoverable backup before maintenance. On a memory-constrained server, assess headroom before starting a new Redis background snapshot/rewrite; this command does not trigger one or change persistence settings.

1. Deploy the decoder and cache-store changes to every application node and long-running worker before compacting existing data. For a rolling release, set `ARCHIVE_COMPRESSION=false` and rebuild configuration before deployment, then enable it after all readers are updated. The single-server default is `true`; the example environment documents the option.
2. Rebuild the application's configuration using the normal deployment process (`php artisan config:cache`) and reload persistent workers/runtimes as appropriate. Avoid a broad Redis flush.
3. Preview a sample, then the full archive dataset. These commands do not change any records:

   ```bash
   php artisan redis:archives:compact --limit=1000
   php artisan redis:archives:compact
   ```

4. Apply verified compression, preferably outside a busy live event:

   ```bash
   php artisan redis:archives:compact --apply
   ```

   The defaults read 25 records at a time and pause 10 ms between batches. For large individual snapshots or a busy server, use `--batch=5 --pause=50`. Progress is printed every five seconds. Payload contents, user names and credentials are never printed. If concurrent changes were skipped, rerun the command. If Redis rejects a write or disconnects, stop and inspect server health; the command never flushes a list to recover.

5. Rerun the preview to check remaining candidates. Compare `redis-cli INFO memory` before/after, including `used_memory`, `used_memory_rss`, `mem_fragmentation_ratio` and `maxmemory_policy`. Freed allocation may not immediately be returned to the OS, so process RSS can lag. The command reports payload bytes; Redis allocation also includes list, allocator, persistence and replication overhead.

Compaction does not set TTLs, trim history, deduplicate old records, enable eviction, change memory limits or restart Redis. It reduces storage size; permanent history will still grow with future events. Assess production key sizes and memory headroom before setting Redis memory policies. A durable SQL/archive-storage tier remains a future option if history outgrows the server.

## Reversal and rollback

Keep the decoder deployed while any compressed values exist. `ARCHIVE_COMPRESSION=false` only disables new compression; it does not remove read compatibility. To restore the exact original JSON bytes:

```bash
php artisan redis:archives:compact --restore
php artisan redis:archives:compact --restore --apply
```

Restoration increases Redis memory usage. Ensure sufficient headroom first. Disable compression in all writers and reload their configuration before restoration. Confirm a subsequent `--restore` preview reports zero candidates before rolling back to code that cannot decode compressed history. Keep the cache-clear protection when possible.

## Verification

The regression suite covers mixed legacy/compressed reads, full model JSON, Unicode/nulls, duplicate entries and order, unchanged TTLs, interrupted runs, concurrent pushes, corrupt/unknown format rejection, restoration and cache clearing in a shared database. Normal Redis cache operations and locks remain functional.

The full PHP suite passes **289 tests / 862 assertions** using SQLite in memory and an isolated Redis 7.2 socket. No production dataset was changed. Maintenance is intended for the application's standalone connection; cluster/replication aggregates and PhpRedis client-side serialization/compression fail closed rather than guessing key placement or encodings.

A local disposable Redis 7.2 fixture with 500 model snapshots and varied generated lyrics used **4,372,112 bytes before** and **1,556,112 bytes after** compaction, a **64.4% reduction** measured with `MEMORY USAGE`. A length-delimited SHA-256 over every decoded record matched the original bytes and order. This fixture is not a prediction for the live server or proof of what caused its earlier process termination.

Useful upstream references: [Redis SCAN](https://redis.io/docs/latest/commands/scan/), [Redis LSET](https://redis.io/docs/latest/commands/lset/), [Redis scripting](https://redis.io/docs/latest/commands/eval/), [Redis INFO](https://redis.io/docs/latest/commands/info/).

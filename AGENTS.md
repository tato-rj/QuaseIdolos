# Cardápio maintenance

## Scope and invariants

- Preserve the existing UI, Portuguese copy, URLs, markup, ordering rules and user interactions. Performance and correctness work must remain invisible to musicians and guests.
- This is Laravel 8 / Laravel Mix 6. Follow `composer.lock` and `package-lock.json`; do not upgrade the framework or dependencies incidentally.
- All live queue writes must acquire the parent event's `withSetlistLock()` **before** checking capacity or editing requests, ordering and set counters. Re-read state inside the transaction. Broadcast only after the transaction succeeds. Retain the existing admin exemptions from capacity/repetition rules.
- Use explicit nullable reads (`sets()->first()`) for the current set. `Set::scopeCurrent()` is legacy: Eloquent turns a null scope result back into a builder, so it cannot safely represent an absent set.
- Keep song modal data current. Do not cache user-specific actions, live counts or whole mutable Eloquent models across requests.
- Eager-load relationships used in loops; keep lyrics and count subqueries out of cardápio listing queries. Keep the two supported cardápio search view names allowlisted.
- Keep browser requests isolated by target. Cancel/ignore obsolete reads, coalesce broadcast refreshes, and destroy old Sortable instances before replacement. Do not cancel a write merely because another refresh arrives.
- Test only with disposable databases and an isolated Redis instance. Never run `migrate:fresh`, `redis:flush`, or the legacy test cleanup against a shared or production service. Do not print `.env` contents or credentials.
- Do not deploy, run production migrations or alter live services without explicit user authorization.

## Validation and release

- Use a PHP version compatible with the installed lockfile (PHP 8.1 is available locally). Run the relevant feature/unit tests, then the complete suite when changing shared live-event behavior.
- JavaScript race regressions: `node --test tests/js/*.test.js`.
- Build tracked production assets with `npm run production`; include `public/js/app.js`, its license file and `public/mix-manifest.json` when changed. Confirm CSS and rendered HTML remain unchanged.
- New migration `2026_10_19_000000_add_live_cardapio_indexes.php` adds only non-unique indexes, with a matching rollback. Plan its production execution around table sizes and the database's DDL locking behavior.
- SQLite tests do not prove MySQL row-lock behavior. Use a disposable MySQL/InnoDB database for concurrent submission/completion/reorder checks before a production release.
- `tests/Support/check-live-concurrency.php` exercises real multi-process submissions/completion and index rollback. It requires `APP_ENV=testing`, `DB_CONNECTION=mysql`, an explicit local `DB_HOST` or `DB_SOCKET`, no `DATABASE_URL` or cached configuration, and an empty database named `quaseidolos_test_*`. It creates schema/data in that disposable database; it does not create or drop the database itself.

## Follow-up improvements

1. **High — membership and cleanup:** `User::join()` / `leave()` bulk-delete waiting requests without maintaining set counters or deleting invitations. Move membership changes and queue cleanup into consistently ordered event/user transactions, preserving current switching behavior. Also audit user/song deletion and scheduled event closure.
2. **High — deployment baseline:** plan a separately tested PHP/Laravel and dependency security update. Verify production debug mode, OPcache, config/view caches, queue workers, retries and failed-job monitoring. Do not assume the local `.env` matches production.
3. **High — reliable side effects:** Redis archival currently happens in `Gig::close()` alongside SQL changes; Redis and SQL cannot commit atomically. Move archival/broadcast delivery to an idempotent after-commit/outbox workflow, with recovery and failure monitoring.
4. **High — lifecycle coordination:** regular event settings (including set limits) now use the event lock, with concurrent limit/submission/cancellation coverage. Extend the contract to pause/password-only changes, winner announcement, scheduled closure and membership/deletion writers; exercise pause/close changes during concurrent submissions.
5. **Medium — request protocol:** the legacy drag reorder uses GET with `newOrder`. Migrate the client/server together to a CSRF-protected write endpoint while preserving drag behavior; keep refresh GET read-only.
6. **Medium — search scaling:** substring `LIKE '%input%'` cannot use a normal name index efficiently. Measure real catalog size and latency before adopting a search index that preserves accents, artist/genre matching and existing result order. Preserve the currently unpaginated change-song flow unless separately authorized.
7. **Medium — telemetry/load:** capture p50/p95 latency, SQL counts, response sizes and contention for search, modal, request, completion, cancellation and setlist refresh under realistic guest counts. Add repeated-submit and multi-worker integration coverage.
8. **Medium — related features:** audit recommendation availability/fallbacks, favorite and invitation concurrency, chat/rating query loops, and cache invalidation for genres/artists. Preserve every existing visible option and flow.

## Review record — 2026-10-19

- Added event transactions for submissions, changes, completion, cancellation, reset, reorder and manual open/close; capacity checks are repeated after the event lock is acquired.
- Added ownership and input checks for request changes and scoped reorder IDs to the active event. Repeated completion is harmless.
- Removed listing lyrics/count overhead, reused modal counts, eager-loaded setlist/participant data, and materialized eligible-event queries once instead of repeatedly executing builders.
- Added indexes for live queue/user/song lookups and related relationships.
- Added independent search/modal cancellation, stale-response rejection, short search coalescing, serialized setlist refresh, and Sortable cleanup. Removed unused Lodash and Moment locale payloads from the main bundle.

### Verification

- Full PHP suite: **262 tests, 485 assertions**, all passing with SQLite in memory and an isolated Redis socket. JavaScript: **8 tests**, all passing. Production Mix build and changed PHP syntax checks pass.
- MySQL/InnoDB: six simultaneous submissions for one event slot accepted exactly one request; six simultaneous submissions for one set slot accepted exactly one request; four simultaneous completions decremented the queue exactly once. The additive index migration and its rollback both succeeded on the disposable database.
- Compared five rendered fixtures against the original revision: guest index/search/modal and admin modal/setlist table have identical HTML after excluding scripts and normalizing CSRF tokens/whitespace. CSS is byte-for-byte unchanged. This checks representative output; it is not a full browser interaction or production load test.
- In those fixtures, admin modal SQL fell from **20 to 14 queries**, and a ten-entry setlist refresh from **67 to 16 queries**. These are reproducible local examples, not production latency measurements.
- Main production JS fell from **714,303 to 416,768 bytes (41.7%)**; gzip size fell from **202,235 to 125,063 bytes**. Production assets are rebuilt. No production deployment or production migration was performed.

## Statistics repair — 2026-10-19

- Artist/genre rankings previously loaded every matching `SongRequest` into PHP, lazily loading songs and related entities per request. With 100 requests, the artist and genre endpoints made 306 and 305 SQL queries respectively in local fixtures. Both now use six queries after middleware warm-up, regardless of history size: SQL groups/counts history and only the top ten entities are hydrated.
- `SongRequest::getRankingBy()` now returns ranked **entity models with `request_count`**, rather than collections of requests. Its only supported dimensions are song, artist, genre and user. Keep the four statistics row templates aligned with that contract. Keep existing counting semantics, including pending requests; do not silently change these reports to completed-only counts.
- Ranking dates now accept/validate both the existing `dd/mm/yyyy` controls and legacy ISO requests. Initial requests send the displayed dates; end dates include the whole day. Missing related records and empty history no longer break rendering.
- The four ranking pages share `pages.statistics.components.ranking-script`. Preserve the controls/markup, reject stale responses, keep a finite request timeout and clear failed initial placeholders using the existing error popup. Preserve the previous table if a subsequent refresh fails.
- Validation: **270 PHP tests / 567 assertions** and **12 JavaScript tests** pass. All eight statistics tests also pass on disposable MySQL 8.4 with strict grouping enabled. A 1,010-request regression checks bounded queries and zero hydration of request history. Original/new HTML matches exactly for the artist, genre, song and user ranking table fixtures; styles and built assets are unchanged.
- Deployment: deploy the changed PHP/Blade files, including the new FormRequest and shared Blade partial. Clear compiled views (`php artisan view:clear`) if the deployment does not already rebuild them. **No additional migration or asset build is needed for this repair.** Existing `LatestRequest` in the tracked main bundle is reused. No production deployment was performed here.
- Future: profile date-range aggregations on production-sized data before adding a dedicated `song_requests.created_at` index or report caching. Do not modify an already-applied migration to add it.

### Statistics default period — 2026-10-19

- All five statistics pages (events/participants, songs, artists, genres and users) initialize their date controls from one calendar year before today through today. Use a copy of the end date and `subYearNoOverflow()` to handle leap days without changing the end date.
- `$firstDate` is the default selected start; `$initialDate` is the earliest selectable date. Keep these separate so older history remains selectable. The picker minimum is the earlier of recorded history and the default start, so the default also works with empty or recent history. Initial chart/ranking requests continue to read the displayed controls.
- Validation: the eight statistics feature tests pass (**110 assertions**), including every page's default values, empty history and selecting pre-default history. All **12 JavaScript tests** pass. Only the default date values changed; controls/layout, historical data and assets are unchanged.
- Deployment: deploy the changed Blade files and clear compiled views (`php artisan view:clear`). No migration, asset build or Redis maintenance is required.

## Redis history memory — 2026-10-19

- Archive snapshots now use versioned, lossless gzip only when smaller; legacy raw JSON stays readable. Preserve the full JSON byte stream, including loaded relationships, rather than removing historical fields or duplicates. Never add archive expiry/retention or automatic eviction as a memory fix.
- Existing history compaction is an explicit maintenance command: `redis:archives:compact` previews; `--apply` atomically replaces only byte-equivalent entries. Restrict scanning and writes to the actual connection prefix and known archive lists. Use bounded batches and throttling; concurrent changes must be skipped, and interruptions must leave all records readable. `--restore --apply` reverses the encoding with sufficient RAM headroom.
- Cache flush must use `HistorySafeRedisStore`, never the framework's whole-database Redis flush. Preserve archive keys, jobs and sessions when they share a database. Do not reintroduce `FLUSHDB`, `FLUSHALL` or a shell-based cleanup connection into this path. The developer/test `redis:flush` remains prohibited in production and checks its actual connection prefix.
- Rollout, backup/persistence checks, rolling-reader compatibility, preview/apply commands and reversal are documented in [docs/redis-archives.md](docs/redis-archives.md). Existing live records were not altered here; no UI, assets, SQL migration or Redis server configuration changed.
- A local 500-snapshot fixture reduced Redis allocation from 4,372,112 to 1,556,112 bytes (64.4%), with every original byte and list position verified. Real savings depend on production data; memory usage does not establish the cause of an earlier SIGKILL.
- Validation: the full PHP suite passes **289 tests / 862 assertions** against SQLite in memory and an isolated Redis 7.2 socket. New tests cover format compatibility, exact full model snapshots, legacy duplicates/order/expiry, concurrent pushes, interrupted runs, corruption, reversal, prefix isolation, safe cache clearing, and normal cache/lock operations. Frontend files and assets are unchanged.

## Live set limits and cancellation repair — 2026-10-19

- A set's accepted-song total is `limit - songs_left`: it includes songs confirmed during the current set and excludes cancellations. Its `queue` tracks waiting songs. Preserve this distinction when changing the current limit; counting only waiting songs forgets confirmations, while counting all event confirmations includes earlier sets.
- Immediate limit changes retain that total, reconcile the waiting queue and update the full/finished flag together. Increasing a full set's limit reopens available slots; lowering it preserves all requests. Deferred changes retain the current set's limit until renewal. An empty set that has reached a newly lowered limit renews normally.
- Creating/enabling a set now counts existing waiting requests. Previously these requests were omitted, so cancelling them could increase `songs_left` beyond `limit` and display a negative total. Cancellation now returns one accepted slot, uses the actual waiting queue as a lower bound and prevents a negative accepted total, including legacy undercounted sets.
- Negative **stored** `songs_left` still represents accepted songs above capacity (admin exemptions or a lowered limit). Preserve that excess until cancelled/completed; clamping the stored value to zero would lose songs and reopen guest submissions too early. The displayed accepted-song total remains nonnegative.
- Regular event settings updates acquire `withSetlistLock()` before modifying the event, musicians, password or set. These SQL changes roll back together and serialize with submissions, confirmations and cancellations. Preserve the existing form, immediate/deferred choices, responses and admin exemptions.
- Validation: **299 PHP tests / 1,044 assertions** and **12 JavaScript tests** pass. All ten new feature regressions also pass on disposable MySQL 8.4 (**182 assertions**). The MySQL concurrency check now covers resizing during submissions, resizing a full set during cancellations, and four competing cancellations returning exactly one slot, alongside existing submission/completion checks.
- Deployment: deploy the changed PHP files. **No migration, Redis maintenance or asset build is required.** Views, scripts, styles and built assets are unchanged; no production service was modified here.
- Future: the legacy schema does not persist per-request set membership, so already-lost current-set confirmation counts cannot be reconstructed reliably from event-wide history. Plan explicit set membership before an automatic historical counter repair. Also audit the tiny-integer counter ranges before supporting large set limits or very large admin overflow queues.

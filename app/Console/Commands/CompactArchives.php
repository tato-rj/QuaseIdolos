<?php

namespace App\Console\Commands;

use App\Archives\{ArchiveCompactor, RedisKeys};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CompactArchives extends Command
{
    protected $signature = 'redis:archives:compact
        {--apply : Replace verified archive values; otherwise only report potential savings}
        {--restore : Restore compressed records to their exact original JSON bytes}
        {--batch=25 : Number of list records read at a time (1-100)}
        {--pause=10 : Milliseconds to pause between batches (0-1000)}
        {--limit=0 : Maximum records inspected, or zero for all archive records}';

    protected $description = 'Losslessly compress event history, preserving every record, list order and expiry';

    public function handle()
    {
        $batch = filter_var($this->option('batch'), FILTER_VALIDATE_INT);
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT);
        $pause = filter_var($this->option('pause'), FILTER_VALIDATE_INT);
        if ($batch === false || $batch < 1 || $batch > 100 || $limit === false || $limit < 0
            || $pause === false || $pause < 0 || $pause > 1000) {
            $this->error('Use --batch=1..100, --pause=0..1000 and a nonnegative --limit.');
            return 1;
        }

        if (! function_exists('gzencode') || ! function_exists('gzdecode')) {
            $this->error('The PHP zlib extension is required. No records were changed.');
            return 1;
        }

        try {
            $compactor = new ArchiveCompactor(new RedisKeys(Redis::connection('default')));
            $lastProgress = microtime(true);
            $result = $compactor->run((bool) $this->option('apply'), (bool) $this->option('restore'), $batch, $limit,
                function ($progress) use ($pause, &$lastProgress) {
                    if ($pause)
                        usleep($pause * 1000);
                    if (microtime(true) - $lastProgress >= 5) {
                        $this->line('Inspected '.$progress['records'].' archive records...');
                        $lastProgress = microtime(true);
                    }
                });
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            $this->warn('The run stopped. Earlier verified replacements remain readable; rerunning is safe.');
            return 1;
        }

        $this->info($this->option('apply') ? 'Applied verified archive replacements.' : 'Dry run: no records changed.');
        $this->table(['Lists visited', 'Records inspected', 'Candidates', 'Changed', 'Concurrent changes skipped'], [
            [$result['lists'], $result['records'], $result['candidates'], $result['changed'], $result['conflicts']],
        ]);
        $this->line('Projected payload bytes for inspected records: '.$result['before_bytes'].' -> '.$result['after_bytes']);
        if ($this->option('apply'))
            $this->line('Verified payload bytes saved: '.$result['saved_bytes']);
        $this->line('Payload sizes exclude Redis overhead; SCAN may revisit keys. No records were deleted.');

        if ($result['conflicts'])
            $this->warn('Some entries changed concurrently. Rerun to inspect them again.');

        return 0;
    }
}

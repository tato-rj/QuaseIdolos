<?php

// Optional integration check. Supply an EMPTY, DISPOSABLE MySQL database named
// quaseidolos_test_*. This never connects to the default application database.
if (getenv('APP_ENV') !== 'testing' || getenv('DB_CONNECTION') !== 'mysql'
    || ! preg_match('/^quaseidolos_test_[a-z0-9_]+$/', getenv('DB_DATABASE') ?: '')
    || (! getenv('DB_SOCKET') && ! in_array(getenv('DB_HOST'), ['127.0.0.1', 'localhost', '::1'], true))
    || getenv('DATABASE_URL')) {
    fwrite(STDERR, "Use APP_ENV=testing, DB_CONNECTION=mysql, an explicit local DB_HOST or DB_SOCKET, an empty quaseidolos_test_* database, and no DATABASE_URL.\n");
    exit(1);
}

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if ($app->configurationIsCached() || config('database.default') !== 'mysql'
    || config('database.connections.mysql.database') !== getenv('DB_DATABASE')
    || config('database.connections.mysql.url')
    || (getenv('DB_SOCKET')
        ? config('database.connections.mysql.unix_socket') !== getenv('DB_SOCKET')
        : config('database.connections.mysql.host') !== getenv('DB_HOST'))) {
    throw new RuntimeException('Resolved configuration does not match the explicit disposable test connection.');
}

use App\Events\{SongRequested, SongFinished, SongCancelled};
use App\Exceptions\SetlistException;
use App\Http\Controllers\{GigsController, SongRequestsController};
use App\Http\Requests\SongRequestForm;
use App\Models\{Admin, Gig, Set, Song, SongRequest, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Artisan, DB, Event};
use Symfony\Component\Process\Process;

Event::fake([SongRequested::class, SongFinished::class, SongCancelled::class]);

if (($argv[1] ?? '') === 'worker') {
    [, , $action, $userId, $songId, $entryId, $ready] = $argv;
    auth()->loginUsingId($userId);
    auth()->user()->checkLiveGig();
    $controller = new SongRequestsController;

    try {
        if ($action === 'store') {
            $song = Song::findOrFail($songId);
            $request = Request::create(route('song-requests.store', $song), 'POST');
            $route = clone app('router')->getRoutes()->getByName('song-requests.store');
            $route->bind($request);
            $route->setParameter('song', $song);
            $form = new SongRequestForm;
            $form->setRouteResolver(function () use ($route) { return $route; });
            if (! $form->authorize())
                $form->failedAuthorization();

            file_put_contents($ready, 'ready');
            $controller->store($request, $song, $form);
        } elseif ($action === 'resize') {
            $gig = Gig::findOrFail($songId);
            $request = Request::create(route('gig.update', $gig), 'PATCH', [
                'venue_id' => $gig->venue_id,
                'set_limit' => $entryId,
                'change_set_limit_now' => 1,
                'musicians' => [],
            ]);

            file_put_contents($ready, 'ready');
            (new GigsController)->update($request, $gig);
        } elseif ($action === 'cancel') {
            file_put_contents($ready, 'ready');
            $controller->cancel($entryId);
        } elseif ($action === 'finish') {
            file_put_contents($ready, 'ready');
            $controller->finish($entryId);
        } else {
            throw new RuntimeException('Unknown worker action.');
        }
        echo "accepted\n";
    } catch (SetlistException $e) {
        echo "limited\n";
    }
    exit(0);
}

if (DB::select('SHOW TABLES'))
    throw new RuntimeException('The integration database must be empty. No tables were changed.');

Artisan::call('migrate', ['--force' => true]);

function concurrent(Gig $gig, array $jobs): array
{
    $directory = sys_get_temp_dir().'/quaseidolos-race-'.uniqid();
    mkdir($directory, 0700);
    $processes = [];
    DB::beginTransaction();

    try {
        Gig::whereKey($gig->id)->lockForUpdate()->firstOrFail();
        foreach ($jobs as $index => $job) {
            $process = new Process(array_merge([PHP_BINARY, __FILE__, 'worker'], $job, [$directory.'/'.$index]));
            $process->setTimeout(30);
            $process->start();
            $processes[] = $process;
        }

        $deadline = microtime(true) + 15;
        while (count(glob($directory.'/*')) < count($jobs)) {
            foreach ($processes as $process) {
                if (! $process->isRunning())
                    throw new RuntimeException('Worker exited before the barrier: '.$process->getErrorOutput().$process->getOutput());
            }
            if (microtime(true) > $deadline)
                throw new RuntimeException('Workers did not reach the lock barrier.');
            usleep(10000);
        }

        // All workers read the same initial state and now contend for this lock.
        DB::commit();
        $results = [];
        foreach ($processes as $process) {
            $process->wait();
            if (! $process->isSuccessful())
                throw new RuntimeException($process->getErrorOutput().$process->getOutput());
            $results[] = trim($process->getOutput());
        }
        return $results;
    } finally {
        if (DB::transactionLevel())
            DB::rollBack();
        foreach ($processes as $process) {
            if ($process->isRunning())
                $process->stop();
        }
        foreach (glob($directory.'/*') as $file)
            unlink($file);
        rmdir($directory);
    }
}

$song = Song::factory()->create();
$users = User::factory()->count(6)->create();

foreach (['songs_limit', 'set_limit'] as $limit) {
    $gig = Gig::factory()->live()->create([$limit => 1]);
    if ($limit === 'set_limit')
        Set::new($gig);
    foreach ($users as $user)
        $user->join($gig);
    $jobs = $users->map(function ($user) use ($song) {
        return ['store', (string) $user->id, (string) $song->id, '0'];
    })->all();
    $results = concurrent($gig, $jobs);
    if ($gig->setlist()->count() !== 1 || count(array_filter($results, function ($result) { return $result === 'accepted'; })) !== 1)
        throw new RuntimeException($limit.' was exceeded: '.json_encode($results));
    echo $limit.": 6 competing submissions, exactly 1 accepted\n";
}

$gig = Gig::factory()->live()->create(['set_limit' => 3]);
Set::new($gig);
$admin = Admin::factory()->create()->user;
$admin->join($gig);
$entry = (new SongRequest)->add($admin, $song, $gig);
(new SongRequest)->add($admin, $song, $gig);
concurrent($gig, array_fill(0, 4, ['finish', (string) $admin->id, '0', (string) $entry->id]));
if ($gig->sets()->first()->queue !== 1 || $gig->setlist()->completed()->count() !== 1)
    throw new RuntimeException('Concurrent completion changed the queue more than once.');
echo "finish: 4 competing completions, exactly 1 queue decrement\n";

$settingsAdmin = Admin::factory()->superAdmin()->create()->user;
$gig = Gig::factory()->live()->create(['set_limit' => 4]);
Set::new($gig);
$settingsAdmin->join($gig);
auth()->login($settingsAdmin);
$entries = collect(range(1, 3))->map(function () use ($settingsAdmin, $song, $gig) {
    return (new SongRequest)->add($settingsAdmin, $song, $gig);
});
(new SongRequestsController)->finish($entries[0]->id);
foreach ($users as $user)
    $user->join($gig);
$jobs = $users->map(function ($user) use ($song) {
    return ['store', (string) $user->id, (string) $song->id, '0'];
})->all();
$jobs[] = ['resize', (string) $settingsAdmin->id, (string) $gig->id, '6'];
$results = concurrent($gig, $jobs);
$accepted = count(array_filter(array_slice($results, 0, 6), function ($result) { return $result === 'accepted'; }));
$set = $gig->sets()->first();
if ($set->limit != 6 || $set->queue != 2 + $accepted || $set->songs_left != 6 - (3 + $accepted)
    || $set->isFinished() !== ($accepted === 3) || $accepted < 1 || $accepted > 3)
    throw new RuntimeException('Concurrent resize/submissions lost confirmed songs or exceeded capacity.');
echo "resize: concurrent submissions preserve confirmed songs and the new capacity\n";

$gig = Gig::factory()->live()->create(['set_limit' => 5]);
Set::new($gig);
$settingsAdmin->join($gig);
$entries = collect(range(1, 5))->map(function () use ($settingsAdmin, $song, $gig) {
    return (new SongRequest)->add($settingsAdmin, $song, $gig);
});
(new SongRequestsController)->finish($entries[0]->id);
(new SongRequestsController)->finish($entries[1]->id);
$jobs = $entries->slice(2)->map(function ($entry) use ($settingsAdmin) {
    return ['cancel', (string) $settingsAdmin->id, '0', (string) $entry->id];
})->values()->all();
$jobs[] = ['resize', (string) $settingsAdmin->id, (string) $gig->id, '4'];
concurrent($gig, $jobs);
$set = $gig->sets()->first();
if ($set->limit != 4 || $set->queue != 0 || $set->songs_left != 2 || $set->isFinished()
    || $gig->setlist()->completed()->count() !== 2)
    throw new RuntimeException('Concurrent resize/cancellations produced inconsistent counters.');
echo "resize/cancel: a full set keeps confirmed songs and returns each cancelled slot once\n";

$gig = Gig::factory()->live()->create(['set_limit' => 2]);
Set::new($gig);
$settingsAdmin->join($gig);
$entry = (new SongRequest)->add($settingsAdmin, $song, $gig);
(new SongRequest)->add($settingsAdmin, $song, $gig);
concurrent($gig, array_fill(0, 4, ['cancel', (string) $settingsAdmin->id, '0', (string) $entry->id]));
$set = $gig->sets()->first();
if ($set->queue != 1 || $set->songs_left != 1 || $set->isFinished() || $gig->setlist()->count() !== 1)
    throw new RuntimeException('Concurrent cancellation returned a slot more than once.');
echo "cancel: 4 competing cancellations, exactly 1 slot returned\n";

// Exercise the reverse migration too, without dropping the integration data.
Artisan::call('migrate:rollback', ['--step' => 1, '--force' => true]);
echo "index migration: applied and rolled back successfully\n";

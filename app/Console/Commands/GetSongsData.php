<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tools\MusicData\MusicData;
use App\Models\Song;

class GetSongsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songs-data:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data for all songs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $songs = Song::whereNull('spotify_id')->with('artist')->take(50)->get();

        foreach($songs as $song) {
            $song->getMusicData();
        }

        $left = Song::whereNull('spotify_id')->count();

        $this->info('All set, '.$left. ' more to go.');
    }
}

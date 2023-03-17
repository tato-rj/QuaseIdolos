<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tools\MusicData\MusicData;
use App\Models\Artist;

class GetArtistsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artists-data:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data for all artists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $artists = Artist::whereNull('spotify_id')->take(20)->get();

        foreach($artists as $artist) {
            $artist->getMusicData();
        }

        $this->info('All set');
    }
}

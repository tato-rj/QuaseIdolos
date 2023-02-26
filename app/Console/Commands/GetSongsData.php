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
        $song = Song::first();

        $data = (new MusicData)->song($song->name);

        $song->update([
            'duration' => $data->duration,
            'bpm' => $data->bpm,
            'preview_url' => $data->preview_url
        ]);

        $this->info('All set');
    }
}

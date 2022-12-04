<?php

namespace Tests;

use App\Models\{Admin, User, Song};
use App\Events\{LyricsRequested, ScoreSubmitted, SongCancelled, SongFinished, SongRequested};

class AppTest extends TestCase
{    
	public function setUp() : void
	{
		parent::setUp();

        \Mail::fake();
        \Event::fake([
            LyricsRequested::class,
            ScoreSubmitted::class,
            SongCancelled::class,
            SongFinished::class,
            SongRequested::class
        ]);
        \Storage::fake();

        $this->redisPrefix = config('database.redis.prefix');
        
        $this->admin = Admin::factory()->create()->user;
        $this->song = Song::factory()->create();

        // $this->beforeApplicationDestroyed(function () {
        //     $this->artisan('redis:flush ' . $this->redisPrefix);
        // });
	}

    protected function signIn($user = null)
    {
        $user = $user ?? User::factory()->create();

        $this->actingAs($user);

        return $user;
    }

    protected function logout()
    {
        \Auth::logout();
    }
}

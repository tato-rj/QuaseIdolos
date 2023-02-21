<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\{Song, Artist, SongRequest, Favorite, User, Genre, Rating};

class SongTest extends AppTest
{
    /** @test */
    public function it_belongs_to_an_artist()
    {
        $this->assertInstanceOf(Artist::class, $this->song->artist);
    }

    /** @test */
    public function it_belongs_to_a_genre()
    {
        $this->assertInstanceOf(Genre::class, $this->song->genre);
    }

    /** @test */
    public function it_has_many_ratings()
    {
        Rating::factory()->create(['song_request_id' => SongRequest::factory()->create(['song_id' => $this->song])]);

        $this->assertInstanceOf(Rating::class, $this->song->ratings->first());
    }

    /** @test */
    public function it_can_belong_to_many_song_requests()
    {
        $this->signIn();

        SongRequest::factory()->create(['song_id' => $this->song]);

        $this->assertInstanceOf(SongRequest::class, $this->song->songRequests->first());
    }

    /** @test */
    public function it_can_belong_to_many_favorites()
    {
        $this->signIn();

        Favorite::factory()->create(['song_id' => $this->song]);

        $this->assertInstanceOf(User::class, $this->song->favorites->first());
    }

    /** @test */
    public function it_knows_its_average_rating()
    {
        $firstSongRequest = SongRequest::factory()->create(['song_id' => $this->song]);
        $secondSongRequest = SongRequest::factory()->create(['song_id' => $this->song]);

        Rating::factory()->create(['song_request_id' => $firstSongRequest, 'score' => 4]);
        Rating::factory()->create(['song_request_id' => $secondSongRequest, 'score' => 2]);

        $this->assertEquals(3, $this->song->ratings->avg('score'));
    }

    /** @test */
    public function it_knows_how_to_generate_a_chords_url()
    {
        $this->assertNotNull(Song::factory()->create()->generateChordsUrl());
    }

    /** @test */
    public function it_knows_how_many_times_it_has_been_favorited()
    {
        $this->assertEquals(0, $this->song->favorites_count);

        Favorite::factory()->create(['song_id' => $this->song]);
        
        $this->assertEquals(1, $this->song->fresh()->favorites_count);
    }

    /** @test */
    public function it_knows_how_many_times_it_has_been_sung()
    {
        $this->assertEquals(0, $this->song->completed_count);

        SongRequest::factory()->create(['song_id' => $this->song]);
        SongRequest::factory()->create(['song_id' => $this->song, 'finished_at' => now()]);
        
        $this->assertEquals(1, $this->song->fresh()->completed_count);
    }

    // /** @test */
    // public function it_knows_how_many_times_it_was_sung_between_two_given_dates()
    // {
    //     SongRequest::factory()->finished()
    //                           ->from(now()->subMonth())
    //                           ->create();

    //     SongRequest::factory()->finished()
    //                           ->from(now()->subMonth())
    //                           ->song($this->song)
    //                           ->create();

    //     SongRequest::factory()->finished()
    //                           ->from(now()->subMonths(2))
    //                           ->song($this->song)
    //                           ->create();

    //     $queryWithNoSongs = Song::withCount('songRequests')->withRequestsBetween(now()->subWeek()->format('d/m/Y'), now()->format('d/m/Y'))->get();

    //     $queryWithSomeSongs = Song::withCount('songRequests')->withRequestsBetween(now()->subMonth()->format('d/m/Y'), now()->format('d/m/Y'))->get();

    //     $queryWithAllSongs = Song::withCount('songRequests')->withRequestsBetween()->get();

    //     $this->assertCount(0, $queryWithNoSongs);

    //     $this->assertCount(1, $queryWithSomeSongs);

    //     $this->assertCount(1, $queryWithAllSongs);
    // }
}

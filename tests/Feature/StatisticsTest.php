<?php

namespace Tests\Feature;

use App\Models\{Admin, Artist, Genre, Song, SongRequest, User};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-10-19 12:00:00');
        $this->actingAs(Admin::factory()->superAdmin()->create()->user);
        $this->singer = User::factory()->create();
    }

    public function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    /** @test */
    public function statistics_pages_render_without_request_history()
    {
        foreach (['gigs', 'songs', 'artists', 'genres', 'users'] as $section)
            $this->get(route('stats.'.$section))->assertOk()
                ->assertSee('value="19/10/2025"', false)->assertSee('value="19/10/2026"', false);

        foreach (['songs', 'artists', 'genres', 'users'] as $section) {
            $this->getJson(route('stats.'.$section))->assertOk()->assertDontSee('<tbody>', false)
                ->assertSee('name="limit"', false)->assertSee('value="10" selected', false);
            $this->getJson(route('stats.'.$section, ['limit' => 100]))->assertOk()
                ->assertDontSee('<tbody>', false)->assertSee('value="100" selected', false);
        }
    }

    /** @test */
    public function rankings_combine_songs_by_artist_and_genre_and_keep_existing_counts()
    {
        $first = Song::factory()->create(['name' => 'First song']);
        $second = Song::factory()->create([
            'artist_id' => $first->artist_id, 'genre_id' => $first->genre_id, 'name' => 'Second song',
        ]);
        $other = Song::factory()->create(['name' => 'Other song']);
        $this->requests($first, 3);
        $this->requests($second, 2);
        $this->requests($other, 1);
        // Rankings historically include both waiting and completed requests.
        SongRequest::first()->update(['finished_at' => now()]);

        foreach (['song.artist_id' => $first->artist_id, 'song.genre_id' => $first->genre_id] as $column => $id) {
            $ranking = SongRequest::getRankingBy($column);
            $this->assertEquals($id, $ranking[0]->id);
            $this->assertSame(5, $ranking[0]->request_count);
            $this->assertSame(1, $ranking[1]->request_count);
        }

        $this->getJson(route('stats.artists'))->assertOk()
            ->assertSeeInOrder([$first->artist->name, '5 vezes', $other->artist->name, '1 vez']);
        $this->getJson(route('stats.genres'))->assertOk()
            ->assertSeeInOrder([$first->genre->name, '5 vezes', $other->genre->name, '1 vez']);
        $this->getJson(route('stats.songs'))->assertOk()
            ->assertSeeInOrder(['First song', '3 vezes', 'Second song', '2 vezes']);
        $this->getJson(route('stats.users'))->assertOk()->assertSee($this->singer->name)->assertSee('6 vezes');
    }

    /** @test */
    public function localized_date_filters_include_the_entire_last_day()
    {
        $inside = Song::factory()->create();
        $before = Song::factory()->create();
        $after = Song::factory()->create();
        $this->requests($before, 1, '2026-10-18 23:59:59');
        $this->requests($inside, 1, '2026-10-19 00:00:00');
        $this->requests($inside, 1, '2026-10-19 23:59:59');
        $this->requests($after, 1, '2026-10-20 00:00:00');

        foreach (['artists' => 'artist', 'genres' => 'genre'] as $section => $relation) {
            $this->getJson(route('stats.'.$section, ['from' => '19/10/2026', 'to' => '19/10/2026']))
                ->assertOk()->assertSee($inside->$relation->name)->assertSee('2 vezes')
                ->assertDontSee($before->$relation->name)->assertDontSee($after->$relation->name);
        }
    }

    /** @test */
    public function iso_dates_from_previously_open_pages_do_not_disable_filtering()
    {
        $inside = Song::factory()->create();
        $outside = Song::factory()->create();
        $this->requests($inside, 1, '2026-10-19 15:00:00');
        $this->requests($outside, 1, '2023-01-11 15:00:00');

        $this->getJson(route('stats.artists', [
            'from' => '2026-10-19T00:00:00.000Z', 'to' => '2026-10-19T23:59:59.999Z',
        ]))->assertOk()->assertSee($inside->artist->name)->assertDontSee($outside->artist->name);

        // The one-year default must not prevent selecting older history.
        foreach (['gigs', 'songs', 'artists', 'genres', 'users'] as $section)
            $this->get(route('stats.'.$section))->assertOk()
                ->assertSee('value="19/10/2025"', false)->assertSee('value="19/10/2026"', false)
                ->assertSee("minDate: new Date('2023-01-11", false);

        $this->getJson(route('stats.artists', ['from' => '11/01/2023', 'to' => '11/01/2023']))
            ->assertOk()->assertSee($outside->artist->name)->assertDontSee($inside->artist->name);
    }

    /** @test */
    public function invalid_or_reversed_date_ranges_return_validation_errors()
    {
        $this->withExceptionHandling();
        $this->getJson(route('stats.artists', ['from' => '31/02/2026']))
            ->assertUnprocessable()->assertJsonValidationErrors('from');
        $this->getJson(route('stats.genres', ['from' => '20/10/2026', 'to' => '19/10/2026']))
            ->assertUnprocessable()->assertJsonValidationErrors('to');
        $this->getJson(route('stats.artists', ['from' => ['invalid']]))
            ->assertUnprocessable()->assertJsonValidationErrors('from');
    }

    /** @test */
    public function deleted_related_records_do_not_break_rankings()
    {
        $valid = Song::factory()->create();
        $deleted = Song::factory()->create();
        $this->requests($valid, 2);
        $this->requests($deleted, 3);
        Song::whereKey($deleted->id)->delete();
        SongRequest::create(['user_id' => null, 'song_id' => 999999, 'created_at' => now()]);

        foreach (['artists', 'genres', 'songs', 'users'] as $section)
            $this->getJson(route('stats.'.$section))->assertOk();

        $this->assertCount(1, SongRequest::getRankingBy('song.artist_id'));
        $this->assertCount(1, SongRequest::getRankingBy('song.genre_id'));
        $this->assertSame(2, SongRequest::getRankingBy('song_id')->first()->request_count);
    }

    /** @test */
    public function rankings_limit_to_ten_and_break_ties_by_first_request()
    {
        $songs = Song::factory()->count(12)->create();
        foreach ($songs as $song)
            $this->requests($song, 1);
        $this->requests($songs[11], 2);

        $ranking = SongRequest::getRankingBy('song.artist_id');
        $this->assertCount(10, $ranking);
        $this->assertEquals($songs[11]->artist_id, $ranking[0]->id);
        $this->assertEquals($songs[0]->artist_id, $ranking[1]->id);
        $this->assertSame(3, $ranking[0]->request_count);
        $this->assertCount(3, SongRequest::getRankingBy('song.genre_id', 3));
    }

    /** @test */
    public function every_ranking_returns_the_selected_number_with_a_matching_selector()
    {
        for ($index = 1; $index <= 101; $index++) {
            $song = Song::factory()->create(['name' => 'Ranking song '.$index]);
            $singer = User::factory()->create(['name' => 'Ranking singer '.$index]);
            SongRequest::factory()->create([
                'song_id' => $song->id, 'user_id' => $singer->id, 'gig_id' => null,
                'created_at' => '2026-10-19 12:00:00',
            ]);
        }

        foreach (['songs', 'artists', 'genres', 'users'] as $section) {
            foreach ([null, 10, 20, 50, 100] as $limit) {
                $parameters = ['from' => '19/10/2025', 'to' => '19/10/2026'];
                if (! is_null($limit))
                    $parameters['limit'] = $limit;

                $response = $this->getJson(route('stats.'.$section, $parameters))->assertOk();
                $document = new \DOMDocument;
                $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
                $xpath = new \DOMXPath($document);
                $this->assertEquals($limit ?? 10, $xpath->query('//tbody/tr')->length);
                $this->assertEquals(1, $xpath->query('//h5/select[@name="limit"]')->length);
                $options = $xpath->query('//select[@name="limit"]/option');
                $this->assertEquals([10, 20, 50, 100], array_map(function ($option) {
                    return (int) $option->getAttribute('value');
                }, iterator_to_array($options)));
                $selected = $xpath->query('//select[@name="limit"]/option[@selected]');
                $this->assertEquals(1, $selected->length);
                $this->assertEquals($limit ?? 10, $selected[0]->getAttribute('value'));
            }
        }
    }

    /** @test */
    public function ranking_sizes_reject_unsupported_or_unbounded_values()
    {
        $this->withExceptionHandling();

        foreach (['songs', 'artists', 'genres', 'users'] as $section) {
            foreach ([0, 11, 1000, -10, 'invalid', [10], '', 10.5] as $limit)
                $this->getJson(route('stats.'.$section, ['limit' => $limit]))
                    ->assertUnprocessable()->assertJsonValidationErrors('limit');
        }
    }

    /** @test */
    public function artist_and_genre_query_cost_does_not_grow_with_history()
    {
        $song = Song::factory()->create();
        $this->requests($song, 10);
        $small = [];
        DB::enableQueryLog();

        foreach (['artists', 'genres'] as $section) {
            DB::flushQueryLog();
            $this->getJson(route('stats.'.$section))->assertOk();
            $small[$section] = count(DB::getQueryLog());
        }

        DB::table('song_requests')->insert(array_fill(0, 1000, [
            'song_id' => $song->id, 'user_id' => $this->singer->id,
            'created_at' => '2026-10-10 12:00:00', 'updated_at' => '2026-10-10 12:00:00',
        ]));
        $retrieved = 0;
        SongRequest::retrieved(function () use (&$retrieved) { $retrieved++; });

        foreach (['artists', 'genres'] as $section) {
            DB::flushQueryLog();
            $this->getJson(route('stats.'.$section, ['limit' => 100]))->assertOk()->assertSee('1010 vezes');
            $large = count(DB::getQueryLog());
            $this->assertLessThanOrEqual($small[$section] + 1, $large);
            $this->assertLessThanOrEqual(12, $large);
        }

        DB::disableQueryLog();
        $this->assertSame(0, $retrieved, 'Statistics must not hydrate request history into PHP.');
    }

    protected function requests(Song $song, $count, $createdAt = '2026-10-19 12:00:00')
    {
        return SongRequest::factory()->count($count)->create([
            'song_id' => $song->id, 'user_id' => $this->singer->id,
            'gig_id' => null, 'created_at' => $createdAt,
        ]);
    }
}

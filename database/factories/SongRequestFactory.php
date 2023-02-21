<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, Song, Gig};
use Carbon\Carbon;

class SongRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gig_id' => function() {
                return Gig::factory()->create()->id;
            },
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'song_id' => function() {
                return Song::factory()->create()->id;
            }
        ];
    }

    public function finished()
    {
        return $this->state(function (array $attributes) {
            return [
                'finished_at' => now()
            ];
        });
    }

    public function from(Carbon $date)
    {
        return $this->state(function (array $attributes) use ($date) {
            return [
                'created_at' => $date
            ];
        });
    }

    public function song(Song $song)
    {
        return $this->state(function (array $attributes) use ($song) {
            return [
                'song_id' => $song
            ];
        });
    }
}

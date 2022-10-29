<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, Song, Gig};

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
}

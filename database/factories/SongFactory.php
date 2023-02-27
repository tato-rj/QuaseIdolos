<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Song, Artist, Genre};

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'artist_id' => function() {
                return Artist::factory()->create()->id;
            },
            'genre_id' => function() {
                return Genre::factory()->create()->id;
            },
            'name' => ucfirst($this->faker->word),
            'bpm' => $this->faker->numberBetween(40, 160)
        ];
    }
}

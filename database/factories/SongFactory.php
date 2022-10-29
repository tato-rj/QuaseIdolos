<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Song, Artist};

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
            'name' => $this->faker->word,
        ];
    }
}

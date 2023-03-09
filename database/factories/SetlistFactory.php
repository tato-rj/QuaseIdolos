<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Show, Song};

class SetlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'show_id' => function() {
                return Show::factory()->create()->id;
            },
            'song_id' => function() {
                return Song::factory()->create()->id;
            }
        ];
    }
}

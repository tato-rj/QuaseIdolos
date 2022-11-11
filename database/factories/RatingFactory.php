<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, SongRequest};

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'song_request_id' => function() {
                return SongRequest::factory()->create()->id;
            },
            'score' => randomFromArray([1,2,3,4,5])
        ];
    }
}

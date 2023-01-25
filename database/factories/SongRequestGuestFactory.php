<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, SongRequest};

class SongRequestGuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'song_request_id' => function() {
                return SongRequest::factory()->create()->id;
            },
            'user_id' => function() {
                return User::factory()->create()->id;
            },
        ];
    }

    public function confirmed()
    {
        return $this->state(function (array $attributes) {
            return [
                'confirmed_at' => now()
            ];
        });
    }
}

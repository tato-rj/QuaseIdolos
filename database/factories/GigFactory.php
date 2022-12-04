<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, Venue};

class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'creator_id' => function() {
                return User::factory()->create()->id;
            },
            'venue_id' => function() {
                return Venue::factory()->create()->id;
            },
            'scheduled_for' => now(),
            'has_ratings' => true
        ];
    }

    public function live()
    {
        return $this->state(function (array $attributes) {
            return [
                'starts_at' => now(),
                'is_live' => true,
            ];
        });
    }
}

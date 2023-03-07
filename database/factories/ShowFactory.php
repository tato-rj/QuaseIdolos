<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User, Venue};

class ShowFactory extends Factory
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
            'scheduled_for' => now()->startOfDay(),
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

    public function paused()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_paused' => true
            ];
        });
    }
}

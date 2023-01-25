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
            'scheduled_for' => now()->startOfDay(),
            'starting_time' => '20:30',
            'has_ratings' => true
        ];
    }

    public function live()
    {
        return $this->state(function (array $attributes) {
            return [
                'starts_at' => now()->startOfDay(),
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

    public function withPassword()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => 'pass'
            ];
        });
    }

    public function sandbox()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_test' => true
            ];
        });
    }
}

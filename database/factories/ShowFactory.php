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
}

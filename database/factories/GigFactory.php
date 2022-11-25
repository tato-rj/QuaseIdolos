<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            'name' => ucfirst($this->faker->word),
            'scheduled_for' => now(),
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
            'has_ratings' => true
        ];
    }
}

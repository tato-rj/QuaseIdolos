<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ucfirst($this->faker->unique()->word);

        return [
            'uid' => $this->faker->unique()->word,
            'name' => $name,
            'slug' => str_slug($name),
            'lat' => geoip()->getLocation()->lat,
            'lon' => geoip()->getLocation()->lon,
        ];
    }
}

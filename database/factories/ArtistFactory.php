<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->name;

        return [
            'name' => $name,
            'slug' => str_slug($name),
            'image_path' => $this->faker->url
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Chat, User};

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'to_id' => function() {
                return User::factory()->create()->id;
            },
            'from_id' => function() {
                return User::factory()->create()->id;
            },
            'message' => $this->faker->sentence
        ];
    }
}

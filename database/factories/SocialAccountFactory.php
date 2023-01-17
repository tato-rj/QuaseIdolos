<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SocialAccountFactory extends Factory
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
            'social_provider' => 'facebook',
            'social_id' => $this->faker->uuid,
            'social_token' => $this->faker->uuid,
            'social_refresh_token' => $this->faker->uuid
        ];
    }
}

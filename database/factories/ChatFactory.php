<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Chat, User, Gig};

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
            'gig_id' => function() {
                return Gig::factory()->create()->id;
            },
            'to_id' => function() {
                return User::factory()->create()->id;
            },
            'from_id' => function() {
                return User::factory()->create()->id;
            },
            'message' => $this->faker->sentence
        ];
    }

    public function from(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'from_id' => $user
            ];
        });
    }

    public function to(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'to_id' => $user
            ];
        });
    }

    public function gig(Gig $gig)
    {
        return $this->state(function (array $attributes) use ($gig) {
            return [
                'gig_id' => $gig
            ];
        });
    }
}

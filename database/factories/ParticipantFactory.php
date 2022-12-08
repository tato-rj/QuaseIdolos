<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Gig, User};

class ParticipantFactory extends Factory
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
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'created_at' => null,
            'updated_at' => null,
        ];
    }

    public function confirmed()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}

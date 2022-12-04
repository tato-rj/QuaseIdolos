<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Admin, User};

class AdminFactory extends Factory
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
            'super_admin' => false
        ];
    }

    public function superAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'super_admin' => true,
            ];
        });
    }
}

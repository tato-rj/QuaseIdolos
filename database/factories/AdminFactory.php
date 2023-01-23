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
            'manage_setlist' => true,
        ];
    }

    public function superAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'manage_events' => true,
                'manage_setlist' => true
            ];
        });
    }

    public function musician()
    {
        return $this->state(function (array $attributes) {
            return [
                'instruments' => json_encode(['piano']),
            ];
        });
    }

    public function sub()
    {
        return $this->state(function (array $attributes) {
            return [
                'manage_events' => false,
                'manage_setlist' => false,
            ];
        });
    }
}

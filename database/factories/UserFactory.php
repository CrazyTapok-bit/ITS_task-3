<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username'   => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => bcrypt('password'),
            'tg_token'   => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}

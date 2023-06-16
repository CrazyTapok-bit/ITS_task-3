<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
            'from' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'to' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'status' => $this->faker->numberBetween(Event::NEW, Event::COMPLETED),
            'user_id' => User::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

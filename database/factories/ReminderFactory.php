<?php

namespace Database\Factories;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
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
            'date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'repeat' => $this->faker->randomElement([
                Reminder::DAILY,
                Reminder::WEEKLY,
                Reminder::MONTHLY,
                Reminder::YEARLY
            ]),
            'user_id' => User::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Reminder;
use App\Models\ReminderDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReminderRepeat>
 */
class ReminderDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reminder = Reminder::withRepeat(Reminder::WEEKLY)->inRandomOrder()->first();

        return [
            'reminder_id' => $reminder->id,
            'day' => $this->faker->randomElement([
                ReminderDay::MONDAY,
                ReminderDay::TUESDAY,
                ReminderDay::WEDNESDAY,
                ReminderDay::THURSDAY,
                ReminderDay::FRIDAY,
                ReminderDay::SATURDAY,
                ReminderDay::SUNDAY
            ])
        ];
    }
}

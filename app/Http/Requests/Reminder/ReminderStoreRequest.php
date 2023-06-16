<?php

namespace App\Http\Requests\Reminder;

use App\Models\Reminder;
use App\Models\ReminderDay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReminderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'   => 'required|string|max:190',
            'color'  => 'required|string',
            'date'   => 'required|date|after_or_equal:today',
            'repeat' => ['sometimes', 'nullable', Rule::in([
                Reminder::DAILY,
                Reminder::WEEKLY,
                Reminder::MONTHLY,
                Reminder::YEARLY
            ])],
            'days'   => 'sometimes|array',
            'days.*' => ['required', 'string', 'distinct', Rule::in([
                ReminderDay::MONDAY,
                ReminderDay::TUESDAY,
                ReminderDay::WEDNESDAY,
                ReminderDay::THURSDAY,
                ReminderDay::FRIDAY,
                ReminderDay::SATURDAY,
                ReminderDay::SUNDAY
            ])]
        ];
    }
}

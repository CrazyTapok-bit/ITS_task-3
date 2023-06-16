<?php

namespace App\Console\Commands;

use App\Jobs\SendMessageReminder;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Нагадування';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Reminder::withNow()
            ->orWhere(function(Builder $builder) {
                $builder->withDaily();
            })->orWhere(function(Builder $builder) {
                $builder->withWeekly();
            })->orWhere(function(Builder $builder) {
                $builder->withMonthly();
            })->orWhere(function(Builder $builder) {
                $builder->withYearly();
            })->chunk(100, function(Collection $reminders) {
                $reminders->each(function(Reminder $reminder) {
                    Log::info($reminder);
                    dispatch(new SendMessageReminder($reminder))->onQueue('event');
                });
            });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Reminder extends Model
{
    use HasFactory;

    public const DAILY   = 'daily';
    public const WEEKLY  = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY  = 'yearly';

    protected $fillable = [
        'name',
        'color',
        'date',
        'repeat'
    ];

    protected $casts = [
        'date' => 'datetime:carbon'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function days(): HasMany
    {
        return $this->hasMany(ReminderDay::class, 'reminder_id', 'id');
    }

    public function scopeWithRepeat(Builder $builder, ...$args): Builder
    {
        return $builder->whereIn('repeat', $args);
    }

    public function scopeWithNow(Builder $builder): Builder
    {
        return $builder->where('date', '>=', now()->startOfMinute())
            ->where('date', '<', now()->startOfMinute()->addMinute());
    }

    public function scopeWithDaily(Builder $builder): Builder
    {
        return $builder->where('repeat', Reminder::DAILY)->where(function(Builder $builder) {
            return $builder->whereTime('date', '>=', now()->startOfMinute()->format('H:i:s'))
                ->whereTime('date', '<', now()->startOfMinute()->addMinute()->format('H:i:s'));
        });
    }

    public function scopeWithWeekly(Builder $builder): Builder
    {
        return $builder->where('repeat', Reminder::WEEKLY)->where(function(Builder $builder) {
            return $builder->whereTime('date', '>=', now()->startOfMinute()->format('H:i:s'))
                ->whereTime('date', '<', now()->startOfMinute()->addMinute()->format('H:i:s'))
                ->whereIn(DB::raw("LOWER(DAYNAME(date))"), [
                    ReminderDay::MONDAY,
                    ReminderDay::TUESDAY,
                    ReminderDay::WEDNESDAY,
                    ReminderDay::THURSDAY,
                    ReminderDay::FRIDAY,
                    ReminderDay::SATURDAY,
                    ReminderDay::SUNDAY
                ]);
        });
    }

    public function scopeWithMonthly(Builder $builder): Builder
    {
        return $builder->where('repeat', Reminder::MONTHLY)->where(function(Builder $builder) {
            return $builder->whereTime('date', '>=', now()->startOfMinute()->format('H:i:s'))
                    ->whereTime('date', '<', now()->startOfMinute()->addMinute()->format('H:i:s'))
                   ->whereRaw("DATE_FORMAT(date, '%y-%d') = DATE_FORMAT(NOW(), '%y-%d')");
        });
    }

    public function scopeWithYearly(Builder $builder): Builder
    {
        return $builder->where('repeat', Reminder::YEARLY)->where(function(Builder $builder) {
            return $builder->whereTime('date', '>=', now()->startOfMinute()->format('H:i:s'))
                ->whereTime('date', '<', now()->startOfMinute()->addMinute()->format('H:i:s'))
                ->whereRaw("DATE_FORMAT(date, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')");
        });
    }
}

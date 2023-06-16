<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    public const NEW        = 0;
    public const IN_PROGRES = 1;
    public const COMPLETED  = 2;

    protected $fillable = [
        'name',
        'color',
        'from',
        'to',
        'status'
    ];

    protected $casts = [
        'from' => 'datetime:carbon',
        'to'   => 'datetime:carbon'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeWithStatus(Builder $builder, ...$args): Builder
    {
        return $builder->whereIn('status', $args);
    }

    public function scopeWithStarted(Builder $builder): Builder
    {
        return $builder->where('from', '<=', now());
    }

    public function scopeWithExpired(Builder $builder): Builder
    {
        return $builder->where('to', '<=', now());
    }
}

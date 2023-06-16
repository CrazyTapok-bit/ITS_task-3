<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderDay extends Model
{
    use HasFactory;

    public const MONDAY    = 'monday';
    public const TUESDAY   = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY  = 'thursday';
    public const FRIDAY    = 'friday';
    public const SATURDAY  = 'saturday';
    public const SUNDAY    = 'sunday';

    protected $fillable = [
        'day'
    ];

    public $timestamps = false;
}

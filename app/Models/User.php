<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'tg_token'
    ];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'sub'  => $this->id,
            'user' => [
                'id'       => $this->id,
                'username' => $this->username,
                'email'    => $this->email,
                'tg_token' => $this->tg_token
            ],
        ];
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PasswordReset extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'password_resets';

    protected $fillable = [
        'email',
        'otp',
        'is_verified',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

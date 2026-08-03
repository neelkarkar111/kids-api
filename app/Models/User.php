<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


#[Fillable(['first_name', 'last_name', 'email', 'password', 'role_id'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    public const TOKEN_NAME = 'auth-token';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    public function children() 
    {
        return $this->hasMany(Children::class, 'parent_id');
    }

    public function role() 
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role?->name === 'Admin';
    }

    public function isParent()
    {
        return $this->role?->name === 'Parent';
    }
}

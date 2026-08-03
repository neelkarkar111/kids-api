<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class UserAuthService
{
    private const TOKEN_NAME = 'auth-token';

    /**
     * Login user and generate access token.
    */
    
    public function login(array $data){

        if (!Auth::attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
        ])) {    
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
        }

        $user = auth()->user()->load('role');

        // Check role exists and is active
        if (!$user->role || !$user->role->status) {
            throw ValidationException::withMessages([
                'email' => ['Your role is inactive. Please contact the administrator.'],
            ]);
        }

        // $abilities = $user->isAdmin()
        //     ? ['admin-access']
        //     : ['parent-access'];

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Register user and generate access token.
    */
    public function register(array $data)
    {
        $parentRole = Role::where('name', 'Parent')->firstOrFail();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $parentRole->id,
        ]);

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout user and delete access token.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
       
}

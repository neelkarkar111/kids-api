<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserAuthService
{
    private const TOKEN_NAME = 'parent-token';

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

        $user = auth()->user();

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
        $user = User::create([
            
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
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

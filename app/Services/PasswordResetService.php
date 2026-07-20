<?php

namespace App\Services;

use App\Mail\ForgotPasswordOtpMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PasswordResetService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Forgot password and send OTP to user's email.
     */
    public function sendResetLink(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        
        if(!$user) {

            throw ValidationException::withMessages([
                'email' => ['No account found with this email address.'],
            ]);
        }

        $otp = (string) random_int(100000, 999999);

        PasswordReset::updateOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(10),
                'is_verified' => false
            ]
        );

        Mail::to($data['email'])->send(new ForgotPasswordOtpMail($otp));
    
        return [
            'message' => 'OTP sent to your email.',
        ];
    }

    /**
     * Verify OTP for password reset.
     */
    public function verifyOtp(array $data)
    {
        $otpRecord = PasswordReset::where('email', $data['email'])->first();

        if (!$otpRecord || !Hash::check($data['otp'], $otpRecord->otp)) 
        {
            throw ValidationException::withMessages([
                'otp' => ['Invalid reset code, Please enter valid verification code.'],
            ]);
        }

        if ($otpRecord->is_verified)
        {
            throw ValidationException::withMessages([
                'otp' => ['OTP has already been verified.'],
            ]);
        }

        if ($otpRecord->expires_at->isPast()) 
        {
            $otpRecord->delete();

            throw ValidationException::withMessages([
                'otp' => ['OTP has expired. Please request a new one.'],
            ]);
        }

        $otpRecord->update([
            'is_verified' => true,
        ]);

        return [
            'message' => 'OTP verified successfully.',
        ];
    }

    /**
     * Reset password after OTP verification.
     */
    public function resetPassword(array $data)
    {
        $otpRecord = PasswordReset::where('email', $data['email'])->first();

        if (!$otpRecord || !$otpRecord->is_verified) 
        {
            throw ValidationException::withMessages([
                'otp' => ['OTP verification is required before resetting the password.'],
            ]);
        }

        if ($otpRecord->expires_at->isPast())
        {
            $otpRecord->delete();

            throw ValidationException::withMessages([
                'otp' => ['OTP has expired. Please request a new one.'],
            ]);
        }

        $user = User::where('email', $data['email'])->first();

        if(!$user)
        {
            throw ValidationException::withMessages([
                'email' => ['Unable to reset password for this account.'],
            ]);
        }

        DB::transaction(function () use ($user, $data, $otpRecord) {

            // update password
            $user->update([
                'password' => Hash::make($data['password']),
            ]);

            // logout user from all devices
            $user->tokens()->delete();

            // Delete OTP so it cannot be reused
            $otpRecord->delete();
        });

        // $otpRecord->delete();

        return [
            'message' => 'Password has been reset successfully.',
        ];
    }
}   

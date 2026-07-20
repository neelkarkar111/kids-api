<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\UserAuthResource;
use App\Services\PasswordResetService;
use App\Services\UserAuthService;
use Illuminate\Http\JsonResponse;


class UserAuthController extends Controller
{

    public function __construct(
        protected UserAuthService $userAuthService,
        protected PasswordResetService $passwordResetService,
    ) {}

    // parent login
    public function login(LoginRequest $request): JsonResponse {

        $result = $this->userAuthService->login($request->validated());

         return ApiResponse::success([
            'user' => new UserAuthResource($result['user']),
            'token' => $result['token']
        ], 'Login successfully', 200);
    }

    // parent signup 
    public function register(RegisterRequest $request): JsonResponse {

        $result = $this->userAuthService->register($request->validated());
 
        return ApiResponse::success([
            'user' => new UserAuthResource($result['user']),
            'token' => $result['token'],
        ],  'User registered successfully', 201);     
    }

    // parent logout
    public function logout(): JsonResponse  
    {
        $this->userAuthService->logout(auth()->user());

        return ApiResponse::success(
            message: 'Logout successful.'
        );
    }

    // forgot password and send otp
    public function sendResetLink(SendResetLinkRequest $request): JsonResponse
    {
        $result = $this->passwordResetService->sendResetLink($request->validated());

        return ApiResponse::success(
            message: $result['message'],
        );
    }

    // verify otp and mark it as verified
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $result = $this->passwordResetService->verifyOtp($request->validated());

        return ApiResponse::success(
            message: $result['message'],
        );
    }

    // reset password after otp verification
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $result = $this->passwordResetService->resetPassword($request->validated());

        return ApiResponse::success(
            message: $result['message'],
        );
    }
}   

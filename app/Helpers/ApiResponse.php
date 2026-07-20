<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Success Response
     */
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $code = 200
    ): JsonResponse {
        $response = [
            'status'  => true,
            'message' => $message,
        ];

        if ($data !== null){
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Error Response
     */
    public static function error(
        string $message = 'Error',
        int $code = 400,
        mixed $errors = null
    ): JsonResponse {
        $response = [
            'status'  => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
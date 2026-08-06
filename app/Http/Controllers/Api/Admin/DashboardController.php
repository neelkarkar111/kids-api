<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(DashboardService $service) {
        return ApiResponse::success(
            $service->dashboard(),
            'Dashboard fetched successfully'
        );
    }
}

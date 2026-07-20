<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChildResource;
use App\Services\SelectChildService;
use Illuminate\Http\Request;

class SelectChildController extends Controller
{
    public function __construct(
        protected SelectChildService $selectChildService,
    ) {}

    public function select(Request $request,) {

        $request->validate([
            'child_id' => ['required', 'integer', 'exists:children,id'],
        ]);

        $child = $this->selectChildService->selectChild($request->child_id);

        return ApiResponse::success(
            'Child selected successfully.',
            new ChildResource($child),
        );
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateChildRequest;
use App\Http\Resources\ChildResource;
use App\Models\Children;
use App\Services\ChildService;
use Illuminate\Http\Request;

class ChildManageController extends Controller
{
    public function __construct(
        protected ChildService $childService
    ) {}

    public function index(Request $request) {

        $childs = $this->childService->all(
            $request->integer('per_page', 10)
        );

        return ChildResource::collection($childs)->additional([
            'status' => true,
            'message' => 'Children list fetched successfully.',
        ]);
        
    }

    public function show(int $id) {

        $child = $this->childService->find($id);

        return ApiResponse::success([
            'child' => new ChildResource($child)
        ], 'Child Found successfully.');
    }

    public function update(UpdateChildRequest $request, int $id)
    {
        $child = $this->childService->find($id);

        $updatedChild = $this->childService->update(
            $child,
            $request->validated(),
        );

        return ApiResponse::success([   
            'child' => new ChildResource($updatedChild),
        ], 'Child updated successfully', 200);
    }

    public function destroy(int $id) {
        $child = $this->childService->find($id);

        $this->childService->delete($child);

        return ApiResponse::success(null, 'Child deleted successfully.');
    }
}

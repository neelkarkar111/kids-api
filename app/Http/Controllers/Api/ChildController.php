<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddChildRequest;
use App\Http\Requests\UpdateChildRequest;
use App\Http\Resources\ChildResource;
use App\Services\ChildService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function __construct(
        protected ChildService $childService,
    ) {}

    // public function all() {
        
    // }

    /**
     * Display a listing of the resource.   
     */
    public function index(): JsonResponse
    {
        $childs = $this->childService->allByParent();

        return ApiResponse::success([
            'children' => ChildResource::collection($childs)
        ], 'Children fetched successfully.', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddChildRequest $request): JsonResponse
    {
        $child = $this->childService->createByParent($request->validated());
    
        return ApiResponse::success([
            'child' => new ChildResource($child),
        ],  'Child created successfully', 201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $child = $this->childService->findByParent($id);

        return ApiResponse::success([
            'child' => new ChildResource($child),
        ], 'Child found successfully');
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildRequest $request, int $id): JsonResponse
    {
        $child = $this->childService->findByParent($id);

        $updatedChild = $this->childService->update(
            $child,
            $request->validated(),
        );

        return ApiResponse::success([   
            'child' => new ChildResource($updatedChild),
        ], 'Child updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $child = $this->childService->findByParent($id);

        $this->childService->delete($child);

        return ApiResponse::success(null, 'Child deleted successfully', 200);
    }

    public function updateScreenTime(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'seconds' => ['required', 'integer', 'min:0'],
        ]);

        $data = $this->childService->updateScreenTime(
            $id,
            $request->seconds
        );

        return ApiResponse::success([
            $data,
            'Screen time updated successfully', 
        ], 200);
    }
    
        
}

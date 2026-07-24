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


    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $childs = $this->childService->all();

        return ApiResponse::success([
            'childs' => ChildResource::collection($childs)
        ], 'All child data', 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddChildRequest $request): JsonResponse
    {
        $child = $this->childService->create(
            $request->validated(),
            $request->file('avatar'),
        );
    
        return ApiResponse::success([
            'child' => new ChildResource($child),
        ],  'Child created successfully', 201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $child = $this->childService->find($id);

        return ApiResponse::success([
            'child' => new ChildResource($child)   
        ], 'Child found successfully');
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildRequest $request, int $id): JsonResponse
    {
        $child = $this->childService->update(
            $request->validated(), 
            $id, 
            $request->file('avatar')
        );

        return ApiResponse::success([   
            'child' => new ChildResource($child),
        ], 'Child updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->childService->delete($id);

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

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParentDetailResource;
use App\Http\Resources\ParentResource;
use App\Services\ParentService;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function __construct(
        protected ParentService $parentService
    ) {
    }

    public function index(Request $request)
    {
        $parents = $this->parentService->getAll(
            $request->integer('per_page', 10)
        );

        return ParentResource::collection($parents)->additional([
            'status' => true,
            'message' => 'Parents fetched successfully.',
        ]);
    }

    public function show(int $id) 
    {
        $parent = $this->parentService->find($id);

        return ApiResponse::success(
            new ParentDetailResource($parent),
            'Parent fetched successfully.'
        );
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
        ]);

        $parent = $this->parentService->update($id, $data);

        return ApiResponse::success(
            new ParentDetailResource($parent->load('children.avatar')),
            'Parent updated successfully.',
        );
    }

    public function destroy(int $id)
    {
        $this->parentService->delete($id);

        return ApiResponse::success(null,'Parent deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAvatarRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Resources\AvatarResource;
use App\Models\Avatar;
use App\Services\AvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function __construct(
        protected AvatarService $avatarService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $avatars = $this->avatarService->index();

        return ApiResponse::success([
            'avatars' => AvatarResource::collection($avatars)
        ], 'Avatar list fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvatarRequest $request): JsonResponse
    {
        $avatar = $this->avatarService->store($request->validated(), $request->file('image'));

        return ApiResponse::success([
            'avatar' => new AvatarResource($avatar)
        ], 'Avatar created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Avatar $avatar): JsonResponse
    {
        $showAvatar = $this->avatarService->show($avatar);

        return ApiResponse::success([
            'avatar' => new AvatarResource($showAvatar),
        ], 'Avatar fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvatarRequest $request, Avatar $avatar): JsonResponse
    {
        $update = $this->avatarService->update(
            $avatar,
            $request->validated(),
            $request->file('image')
        );

        return ApiResponse::success([
            'avatar' => new AvatarResource($update),
        ], 'Avatar update successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Avatar $avatar): JsonResponse
    {
        $this->avatarService->destroy($avatar);

        return ApiResponse::success(null, 'Avatar deleted successfully');
    }
}

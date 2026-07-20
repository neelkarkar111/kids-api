<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Http\Resources\MissionResource;
use App\Models\Children;
use App\Models\Mission;
use App\Services\MissionService;
use App\Services\RewardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissionController extends Controller
{

    public function __construct(
        protected MissionService $missionService,
        protected RewardService $rewardService
    ) {}


    /**
     * Display all missions.
     */
    public function index()
    {
        $missions = $this->missionService->all();

        return ApiResponse::success([
            'missions' => MissionResource::collection($missions)
        ], 'All missions fetched successfully', 200);
    }

    /**
     * Store a newly created mission in storage.
     */
    public function store(AddMissionRequest $request) : JsonResponse
    {
        $mission = $this->missionService->create($request->validated());

        return ApiResponse::success([
            'mission' => new MissionResource($mission)
        ], 'Mission created successfully', 201);
    }

    /**
     * Display the specified mission.
     */
    public function show(string $id)
    {
            $mission = $this->missionService->find($id);

            return ApiResponse::success([
                'mission' => new MissionResource($mission)
            ], 'Mission fetched successfully', 200);
    }

    /**
     * Update the specified mission in storage.
     */
    public function update(UpdateMissionRequest $request, int $id) : JsonResponse
    {
        $mission = $this->missionService->update($request->validated(), $id);

        return ApiResponse::success([
            'mission' => new MissionResource($mission)
        ], 'Mission updated successfully', 200);
    }

    /**
     * Remove the specified mission from storage.
     */
    public function destroy(int $id)
    {
        $this->missionService->delete($id);

        return ApiResponse::success([], 'Mission deleted successfully');
    }

    public function completeMission(Children $child, Mission $mission)
    {
        // $child = auth()->user()->child;

        $result = $this->missionService->completeMission($child, $mission);

        // if(!$result) 
        // {
        //     return ApiResponse::error('Mission already completed', 409);
        // }

        return ApiResponse::success([$result, 'Mission completed successfully', 200]);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameZoneRequest;
use App\Http\Requests\UpdateGameZoneRequest;
use App\Http\Resources\GameZoneResource;
use App\Models\GameZone;
use App\Services\GameZoneService;

class GameZoneController extends Controller
{
    public function __construct(
        protected GameZoneService $gameZoneService
    ) {}

    public function index() {
        
        $games = GameZone::where('is_active', true)->orderBy('sort_order')->get();

        return ApiResponse::success([
            GameZoneResource::collection($games)
        ], 'Game data fetched successfully', 200);
    }

    public function store(StoreGameZoneRequest $request) {

         $gameZone = $this->gameZoneService->create($request->validated(), $request->file('icon'));

         return ApiResponse::success([
            "data" => new GameZoneResource($gameZone),
         ], 'Game data created successfully.', 201);

    }

    public function show(GameZone $gameZone) {

        return ApiResponse::success([
            'data' =>new GameZoneResource($gameZone),
        ], 'Game data retrieved successfully.', 200);
    }

    public function update(UpdateGameZoneRequest $request, GameZone $gameZone) {

    $Updategame = $this->gameZoneService->update(
            $gameZone,
            $request->validated(),
            $request->file('icon')
        );

        return ApiResponse::success([
            'data' => new GameZoneResource($Updategame),
        ], 'Game data update successfully.', 200);
    }

    public function destroy(GameZone $gameZone) {

        $this->gameZoneService->delete($gameZone);

        return ApiResponse::success(null, 'Game data deleted successfully.');
    }
}

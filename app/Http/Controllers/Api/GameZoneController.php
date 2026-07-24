<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameZoneResource;
use App\Models\Game;
use App\Models\GameZone;

class GameZoneController extends Controller
{
    public function index() {
        
        $games = GameZone::where('is_active', true)->orderBy('sort_order')->get();

        return ApiResponse::success(
            GameZoneResource::collection($games)
        );
    }

    public function show(int $id) {

        $game = GameZone::where('id', $id)->where('is_active', true)->firstOrFail();

        return ApiResponse::success(
            new GameZoneResource($game),
        );
    }
}

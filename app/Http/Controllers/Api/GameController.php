<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->get();

        return ApiResponse::success(
            GameResource::collection($games),
            'Games fetched successfully'
        );
    }

     public function show(int $id)
    {
        $game = Game::where('id', $id)->where('is_active', true)->firstOrFail();

        return ApiResponse::success(
            new GameResource($game),
            'Game details fetched successfully'
        );
    }
}

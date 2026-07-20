<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index() {
        
        $games = Game::where('is_active', true)->orderBy('sort_order')->get();

        return ApiResponse::success(
            GameResource::collection($games)
        );
    }
}

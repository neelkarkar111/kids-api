<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameTestResource;
use App\Models\Game;
use App\Services\GameService;

class GameController extends Controller
{
    public function __construct(
        protected GameService $gameService
    ) {}

    public function index() {

        $games = Game::where('is_active', true)->get();

        return ApiResponse::success(
            GameTestResource::collection($games),
            'Games fetched successfully', 
            200
        );
    }

    public function store(StoreGameRequest $request) {

        $game = $this->gameService->create($request->validated());

        return ApiResponse::success(
                new GameTestResource($game),
                'Game created successfully.',
                201
            );
    }

    public function show(Game $game) {
        // $game = Game::where('id', $id)->where('is_active', true)->firstOrFail();

        return ApiResponse::success(
            new GameTestResource($game),
            'Game details fetched successfully',
            200
        );
    }

    public function update(UpdateGameRequest $request, Game $game) {

        $game = $this->gameService->update(
            $game,
            $request->validated()
        );

        return ApiResponse::success(
            new GameTestResource($game),
            'Game updated successfully.',
            200
        );
    }

    public function destroy(Game $game)
    {
        $this->gameService->delete($game);

        return ApiResponse::success(
            null,
            'Game deleted successfully.',
            200
        );
    }
}

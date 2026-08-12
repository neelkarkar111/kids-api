<?php

namespace App\Services;

use App\Models\Game;
use App\Repositories\GameRepository;

class GameService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected GameRepository $gameRepository,
    ) {}

    public function all(int $perPage = 10) {

        return $this->gameRepository->all($perPage);
    }

    public function create(array $data) {

        return $this->gameRepository->create($data);
    }

    public function update(Game $game, array $data) {

        return $this->gameRepository->update($game, $data);
    }

    public function delete(Game $game) {

        return $this->gameRepository->delete($game);
    }
}

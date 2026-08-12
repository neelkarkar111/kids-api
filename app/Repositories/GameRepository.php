<?php

namespace App\Repositories;

use App\Models\Game;

class GameRepository
{
    public function all(int $perPage = 10) {

        return Game::latest()->paginate($perPage);
    }

    public function create(array $data) {

        return Game::create($data);
    }

    public function update(Game $game, array $data) {

        if (isset($data['data'])) {
            $data['data'] = array_replace_recursive(
                $game->data ?? [],
                $data['data']
            );
        }

        $game->update($data);

        return $game->fresh();
    }

    public function delete(Game $game) {

        return $game->delete();
    }

}

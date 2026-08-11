<?php

namespace App\Repositories;

use App\Models\GameZone;

class GameZoneRepository
{
    public function all($perPage = 10){

        return GameZone::orderBy('sort_order')->paginate($perPage);
    }

    public function create(array $data){

        return GameZone::create($data);
    }

    public function update(GameZone $gameZone, array $data) {

        $gameZone->update($data);

        return $gameZone->fresh();
    }

    public function delete(GameZone $gameZone) {
        
        return $gameZone->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Mission;
use App\Models\MissionCompletion;

class MissionRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function all() 
    {
        return Mission::where('is_active', true)->get();
    }

    public function create(array $data) 
    {
        return Mission::create($data);
    }

    public function find(int $id) 
    {
        return Mission::findOrFail($id);
    }

    public function update(array $data, int $id) 
    {
        $mission = $this -> find($id);
        $mission -> update($data);
        return $mission;
    }

    public function delete(int $id) 
    {
        $mission = $this -> find($id);
        return $mission -> delete();
    }

    public function hasCompleted(int $missionId, int $childId): bool 
    {
        return MissionCompletion::where([
            'mission_id' => $missionId,
            'child_id' => $childId
        ])->exists();
    }

    public function completed(int $missionId, int $childId)
    {
        return MissionCompletion::create([
            'mission_id' => $missionId,
            'child_id' => $childId,
            'completed_at' => now(),
            
        ]);
    }
}

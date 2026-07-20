<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\Children;
use App\Models\Mission;
use App\Repositories\MissionRepository;
use Illuminate\Support\Facades\DB;

class MissionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected MissionRepository $missionRepository,
        protected RewardService $rewardService
    ) {}

    public function all() 
    {
        return $this->missionRepository->all();
    }

    public function create(array $data) 
    {
        return $this->missionRepository->create($data);
    }

    public function find(int $id)
    {
        return $this->missionRepository->find($id);
    }

    public function update(array $data, int $id)
    {
        return $this->missionRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->missionRepository->delete($id);
    }
    

    public function completeMission(Children $child, Mission $mission)
    {
        if(!$mission->is_active) 
        {
            throw new \Exception('Mission is not active');
        }

        if($this->missionRepository->hasCompleted($mission->id, $child->id)) 
        {
            throw new \Exception('Mission already completed');
        }

        DB::transaction(function () use ($child, $mission) 
        {
            $this->missionRepository->completed($mission->id, $child->id);

            $this->rewardService->giveMissionReward($child, $mission);
        });

        $child->refresh();

        return [
            'coins' => $child->coins,
            'xp' => $child->xp
        ];
    }

}

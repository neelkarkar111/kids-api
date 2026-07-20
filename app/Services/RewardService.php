<?php

namespace App\Services;

use App\Models\Children;
use App\Models\Mission;

class RewardService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function giveMissionReward(Children $child, Mission $mission): void
    {
        $child->increment('coins', $mission->reward_coins);
        $child->increment('xp', $mission->reward_xp);
    }
    
}

<?php

namespace App\Services;

use App\Models\Children;
use App\Models\Game;
use App\Models\Mission;
use App\Models\User;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function dashboard() {
        return [
            'total_parents' => User::where('role_id', 2)->count(),
            'total_children' => children::count(),
            'active_children_today' => Children::whereDate('last_active_date', today())->count(),
            'total_games' => Game::count(),
            'total_mission' => Mission::count(),
        ];
    }
}

<?php

namespace App\Repositories;

use App\Models\Children;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ChildRepository 
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // Get all children for the authinticated user
    public function all() {
        
        return auth()->user()->children()->with('avatar')->get();
    }
    
    // Create a new child
    public function create(array $data) {

        return auth()->user()->children()->create($data)->load('avatar');   
    }

    // Find a child by ID
    public function find(int $id) {

        return auth()->user()->Children()->with('avatar')->findOrFail($id);
    }   

    // Update a child by ID
    public function update(array $data, int $id) {
        
        $child = $this->find($id);

        $child->update($data);
        return $child->fresh()->load('avatar');
    }

    // Delete a child by ID
    public function delete(int $id, $avatar = null) {
        
        $child = $this->find($id);

        return $child->delete();
    }

    // update the screen time for a child
    public function updateScreenTime(int $id, int $secounds){

        $child = Children::findOrFail($id);

        $today = Carbon::today()->toDateString();

           // Reset if a new day has started
        if ($child->screen_time_date != $today) {
            $child->today_screen_time = 0;
            $child->screen_time_date = $today;
        }

        $child->today_screen_time += $secounds;
        $child->save();

        return [
            'today_screen_time' => $child->today_screen_time,
            'minutes' => floor($child->today_screen_time / 60),
            'formatted' => gmdate('H:i:s', $child->today_screen_time),
        ];
    }

    public function updateDailyStreak(Children $child) {

        $today = Carbon::today();

        if (is_null($child->last_active_date)) {
                $child->daily_streak = 1;
                $child->last_active_date = $today;
                $child->save();

            return $child->fresh();
        }

        $lastActive = Carbon::parse($child->last_active_date);

        // Already opened today
        if ($lastActive->isSameDay($today)) {
            return $child;
        }

        // Yesterday
        if ($lastActive->isSameDay($today->copy()->subDay())) {
            $child->daily_streak++;
        } else {
            // Missed one or more days
            $child->daily_streak = 1;
        }

        $child->last_active_date = $today;
        $child->save();

        return $child->fresh();
            
        }
}   

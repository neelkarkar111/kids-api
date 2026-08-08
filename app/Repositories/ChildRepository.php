<?php

namespace App\Repositories;

use App\Models\Children;
use Carbon\Carbon;

class ChildRepository 
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    /*
    |--------------------------------------------------------------------------
    | Parent
    |--------------------------------------------------------------------------
    */
    
    public function allByParent() {
        
        return auth()->user()->children()->with('avatar')->get();
    }
    
    public function createByParent(array $data) {

        return auth()->user()->children()->create($data)->load('avatar');   
    }

    public function findByParent(int $id) {

        return auth()->user()->Children()->with('avatar')->findOrFail($id);
    }   

    /*
    |--------------------------------------------------------------------------
    | Admin 
    |--------------------------------------------------------------------------
    */

    public function all(int $perPage = 10) {
        return Children::with('avatar')->latest()->paginate($perPage);
    }

    public function find(int $id) {

        return Children::with('avatar')->findOrFail($id); 
    }

    /*
    |--------------------------------------------------------------------------
    | Common
    |--------------------------------------------------------------------------
    */

    public function update(Children $child, array $data) {  

        $child->update($data);

        return $child->fresh()->load('avatar');
    }

    // Delete a child by ID
    public function delete(Children $child) {
        
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

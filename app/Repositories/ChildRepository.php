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
        
        return auth()->user()->Children;
    }
    
    // Create a new child
    public function create(array $data, $avatar = null) {
        
        if($avatar){
            $data['avatar'] = $avatar->store('avatars', 'public');
        }

        return auth()->user()->children()->create($data);   
    }

    // Find a child by ID
    public function find(int $id) {

        return auth()->user()->Children()->findOrFail($id);
    }   

    // Update a child by ID
    public function update(array $data, int $id, $avatar = null) {
        
        $child = $this->find($id);

        if($avatar) {
            //delete old avatar
            if($child->avatar && Storage::disk('public')->exists($child->avatar)) {
                Storage::disk('public')->delete($child->avatar);
            }

            //store new avatar
            $data['avatar'] = $avatar->store('avatars', 'public');
        }

        $child->update($data);
        return $child->fresh();
    }

    // Delete a child by ID
    public function delete(int $id, $avatar = null) {
        
        $child = $this->find($id);

        if($avatar) {
            //delete avatar file
            if($child->avatar && Storage::disk('public')->exists($child->avatar)) {
                Storage::disk('public')->delete($child->avatar);
            }
        }
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

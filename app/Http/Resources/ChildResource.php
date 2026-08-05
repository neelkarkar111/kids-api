<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'avatar' => [
                'id' => $this->avatar?->id,
                'name' => $this->avatar?->name,
                'image' => $this->avatar
                    ? Storage::url($this->avatar->image)
                    : null,
            ],           
            'coins' => $this->coins,
            'xp' => $this->xp,
            'level' => $this->level,
            'progress' => $this->progress,
            'streak' => $this->streak,
            'last_active_date' => $this->last_active_date,
            'completed_missions' => $this->completed_missions,
            'today_screen_time' => $this->today_screen_time,
            'screen_time_date' => $this->screen_time_date,
            'created_at' => $this->created_at?->toIsoString(),
            'updated_at' => $this->updated_at?->toIsoString(),
        ];
    }
}

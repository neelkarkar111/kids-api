<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GameResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'icon' => $this->icon 
                ? url(Storage::url($this->icon)) 
                : null,
            'difficulty' => $this->difficulty,
            'reward_coins' => $this->reward_coins,
            'reward_xp' => $this->reward_xp,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}

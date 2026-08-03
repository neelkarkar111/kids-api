<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => [
                'role_id' => $this->role->id,
                'role_name' => $this->role->name,
            ],
            'email_verified_at' => $this->email_verified_at?->toIsoString(),
            'created_at' => $this->created_at->toIsoString(),
            'updated_at' => $this->updated_at->toIsoString(),
        ];

    }
}

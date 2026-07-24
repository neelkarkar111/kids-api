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
            'type' => $this->type,
            'data' => $this->formatData($this->data),
            'is_active' => (bool) $this->is_active,
        ];
    }

    private function formatData(?array $data): array
    {
        if (!$data) {
            return [];
        }

        return $this->formatImages($data);
    }

    private function formatImages(array $data): array
    {
        foreach ($data as $key => &$value) {

            if (is_string($value) && str_starts_with($value, 'games/')) {

                $value = url(Storage::url($value));
            }

            if (is_array($value)) {
                $value = $this->formatImages($value);
            }
        }
        unset($value);
        return $data;
    }
}

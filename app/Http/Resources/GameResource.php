<?php

namespace App\Http\Resources;

use App\Services\MemoryMasterService;
use App\Services\WordSearchService;
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

        // Dynamic Word Search
        // if ($this->type === 'word_search') {
        //     $generator = app(WordSearchService::class);

        //     $game = $generator->generate(
        //         $data['words'] ?? [],
        //         $data['grid_size'] ?? 7
        //     );

        //     $data['target_word'] = $game['target_word'];
        //     $data['grid'] = $game['grid'];

        //     // Don't send all possible words to frontend
        //     unset($data['words']);
        // }

        // Dynamic Word Search
        if ($this->type === 'word_search') {

            $generator = app(WordSearchService::class);

            return [
                'words' => $generator->generate(
                    $data['words'] ?? [],
                    $data['grid_size'] ?? 7
                ),
            ];
        }

        // Dynamic Memory Master
        if ($this->type === 'memory_master') {
            $generator = app(MemoryMasterService::class);

            $data['patterns'] = $generator->generate(
                $data['colors'] ?? [],
                $data['total_levels'] ?? 7,
                2
            );
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

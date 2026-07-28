<?php

namespace App\Services;

class MemoryMasterService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generate(array $colors, int $totalLevels = 7, int $startLength = 2): array {
         if (empty($colors) || $totalLevels < 1 || $startLength < 1) {
            return [];
        }

        // Generate the first sequence with 2 random colours
        $sequence = [];

        for ($i = 1; $i <= $startLength; $i++) {
            $sequence[] = $colors[array_rand($colors)];
        }

        $patterns = [];

        for ($level = 0; $level < $totalLevels; $level++) {

            $patterns[] = [
                'level' => $level,
                'sequence' => $sequence,
            ];

            // Add one random colour for the next level
            if ($level < $totalLevels) {
                $sequence[] = $colors[array_rand($colors)];
            }
        }

        return $patterns;
    }
}


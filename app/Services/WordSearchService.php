<?php

namespace App\Services;

class WordSearchService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // public function generate(array $words, int $gridSize = 7): array {
    //     $word = collect($words)
    //         ->map(fn ($word) => strtoupper($word))
    //         ->filter(fn ($word) => strlen($word) <= $gridSize)
    //         ->random();

    //     $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, null));

    //     $directions = [
    //         [0, 1],   // Right
    //         [1, 0],   // Down
    //         [1, 1],   // Diagonal down-right
    //         [1, -1],  // Diagonal down-left
    //     ];

    //     $placed = false;

    //     while (! $placed) {
    //         $direction = $directions[array_rand($directions)];

    //         $row = rand(0, $gridSize - 1);
    //         $col = rand(0, $gridSize - 1);

    //         if ($this->canPlaceWord(
    //             $grid,
    //             $word,
    //             $row,
    //             $col,
    //             $direction,
    //             $gridSize
    //         )) {
    //             $this->placeWord(
    //                 $grid,
    //                 $word,
    //                 $row,
    //                 $col,
    //                 $direction
    //             );

    //             $placed = true;
    //         }
    //     }

    //     // Fill empty cells with random letters
    //     for ($row = 0; $row < $gridSize; $row++) {
    //         for ($col = 0; $col < $gridSize; $col++) {
    //             if ($grid[$row][$col] === null) {
    //                 $grid[$row][$col] = chr(rand(65, 90));
    //             }
    //         }
    //     }

    //     return [
    //         'target_word' => $word,
    //         'grid' => $grid,
    //     ];
    // }

    // private function canPlaceWord(
    //     array $grid,
    //     string $word,
    //     int $row,
    //     int $col,
    //     array $direction,
    //     int $gridSize
    // ): bool {
    //     $wordLength = strlen($word);

    //     for ($i = 0; $i < $wordLength; $i++) {
    //         $newRow = $row + ($direction[0] * $i);
    //         $newCol = $col + ($direction[1] * $i);

    //         // Outside grid
    //         if ($newRow < 0 || $newRow >= $gridSize || $newCol < 0 || $newCol >= $gridSize) {
    //             return false;
    //         }

    //         // Cell already has a different letter
    //         if ($grid[$newRow][$newCol] !== null && $grid[$newRow][$newCol] !== $word[$i]) {
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    // private function placeWord(
    //     array &$grid,
    //     string $word,
    //     int $row,
    //     int $col,
    //     array $direction
    // ): void {
    //     for ($i = 0; $i < strlen($word); $i++) {
    //         $newRow = $row + ($direction[0] * $i);
    //         $newCol = $col + ($direction[1] * $i);

    //         $grid[$newRow][$newCol] = $word[$i];
    //     }
    // }

    private array $directions = [
        [0, 1],
        [1, 0],
        [1, 1],
        [1, -1],
    ];

    /**
     * Generate all puzzles.
     */
    public function generate(array $words, int $gridSize = 7): array
    {
        shuffle($words);

        $result = [];

        foreach ($words as $word) {

            $word = strtoupper(trim($word));

            $result[] = [
                'word' => $word,
                'grid' => $this->generateGrid($word, $gridSize),
            ];
        }

        return $result;
    }

    /**
     * Generate a single puzzle.
     */
    private function generateGrid(string $word, int $gridSize): array
    {
        if (strlen($word) > $gridSize) {
            throw new \RuntimeException(
                "Word '{$word}' is longer than grid size {$gridSize}."
            );
        }

        $grid = array_fill(
            0,
            $gridSize,
            array_fill(0, $gridSize, null)
        );

        $positions = [];

        foreach ($this->directions as $direction) {

            for ($row = 0; $row < $gridSize; $row++) {

                for ($col = 0; $col < $gridSize; $col++) {

                    if (
                        $this->canPlaceWord(
                            $grid,
                            $word,
                            $row,
                            $col,
                            $direction,
                            $gridSize
                        )
                    ) {
                        $positions[] = [
                            'row' => $row,
                            'col' => $col,
                            'direction' => $direction,
                        ];
                    }
                }
            }
        }

        if (empty($positions)) {
            throw new \RuntimeException(
                "Unable to place word '{$word}'."
            );
        }

        $position = $positions[array_rand($positions)];

        $this->placeWord(
            $grid,
            $word,
            $position['row'],
            $position['col'],
            $position['direction']
        );

        return $this->fillRandomLetters($grid);
    }

    /**
     * Check whether a word can be placed.
     */
    private function canPlaceWord(
        array $grid,
        string $word,
        int $row,
        int $col,
        array $direction,
        int $gridSize
    ): bool {

        $length = strlen($word);

        for ($i = 0; $i < $length; $i++) {

            $newRow = $row + ($direction[0] * $i);
            $newCol = $col + ($direction[1] * $i);

            if ($newRow < 0 || $newRow >= $gridSize || $newCol < 0 || $newCol >= $gridSize) {
                return false;
            }

            if ($grid[$newRow][$newCol] !== null && $grid[$newRow][$newCol] !== $word[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Place word into grid.
     */
    private function placeWord(
        array &$grid,
        string $word,
        int $row,
        int $col,
        array $direction
    ): void {

        $length = strlen($word);

        for ($i = 0; $i < $length; $i++) {

            $newRow = $row + ($direction[0] * $i);
            $newCol = $col + ($direction[1] * $i);

            $grid[$newRow][$newCol] = $word[$i];
        }
    }

    /**
     * Fill remaining cells with random letters.
     */
    private function fillRandomLetters(array $grid): array
    {
        $size = count($grid);

        for ($row = 0; $row < $size; $row++) {

            for ($col = 0; $col < $size; $col++) {

                if ($grid[$row][$col] === null) {

                    $grid[$row][$col] = chr(random_int(65, 90));
                }
            }
        }

        return $grid;
    }
}

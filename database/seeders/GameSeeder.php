<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Find Difference',
                'type' => 'find_difference',
                'description' => 'Find 3 hidden differences!',
                'data' => [
                    'lives' => 3,
                    'difference_count' => 3,
                    'image_left' => 'games/find-difference/image-left.png',
                    'image_right' => 'games/find-difference/image-right.png',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Animal Home Match',
                'type' => 'animal_home_match',
                'description' => 'Match animals to their correct homes!',
                'data' => [
                    'lives' => 3,
                    'total_matches' => 4,

                    'animals' => [
                        [
                            'id' => 1,
                            'name' => 'Fish',
                            'image' => 'games/drag-and-drop/fish.png',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Lion',
                            'image' => 'games/drag-and-drop/fish.png',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Camel',
                            'image' => 'games/drag-and-drop/fish.png',
                        ],
                        [
                            'id' => 4,
                            'name' => 'Penguin',
                            'image' => 'games/drag-and-drop/fish.png',
                        ],
                    ],

                    'homes' => [
                        [
                            'id' => 1,
                            'name' => 'Desert',
                            'image' => 'games/drag-and-drop/ocean.png',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Ocean',
                            'image' => 'games/drag-and-drop/ocean.png',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Ice',
                            'image' => 'games/drag-and-drop/ocean.png',
                        ],
                        [
                            'id' => 4,
                            'name' => 'Forest',
                            'image' => 'games/drag-and-drop/ocean.png',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Word Search',
                'type' => 'word_search',
                'description' => 'Find all 7 hidden words!',
                'data' => [
                    'lives' => 3,
                    'total_words' => 7,
                    'words' => [
                        'PLANET',
                        'CAPTAIN',
                        'FREEDOM',
                        'MYSTERY',
                        'JOURNEY',
                        'ANIMALS',
                        'RAINBOW',
                    ],
                ],
            ],
            [
                'title' => 'Memory Master',
                'type' => 'memory_master',
                'description' => 'Remember and repeat the color sequence!',
                'data' => [
                    'lives' => 3,
                    'total_levels' => 7,
                    'colors' => [
                        'red',
                        'blue',
                        'green',
                        'yellow',
                    ],
                ],
            ],
            [
                'title' => 'Code Breaker',
                'type' => 'code_breaker',
                'description' => 'Crack The 3-Digit Secret Code',
                'data' => [
                    'total_attempts' => 15,
                ],
            ],
            [
                'title' => 'Sudoku Lite',
                'type' => 'sudoku_lite',
                'description' => 'Fill The Missing Numbers',
                'data' => [
                    'lives' => 3,

                    'solution' => [
                        [1,2,3,4],
                        [3,4,1,2],
                        [2,1,4,3],
                        [4,3,2,1],
                    ],

                    'puzzle' => [
                        [1,0,3,4],
                        [3,4,0,2],
                        [2,1,4,0],
                        [0,3,2,1],
                    ],
                ],
            ]
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['type' => $game['type']],
                $game
            );
        }
    }
}

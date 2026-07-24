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
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['type' => $game['type']],
                $game
            );
        }
    }
}

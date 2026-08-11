<?php

namespace Database\Seeders;

use App\Models\GameZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Find Difference',
                'slug' => 'find-difference',
                'icon' => 'games/icons/find-difference.png',
                'difficulty' => 'Easy',
                'reward_coins' => 50,
                'reward_xp' => 20,
                'sort_order' => 1,
            ],
            [
                'title' => 'Drag & Drop',
                'slug' => 'drag-drop',
                'icon' => 'games/icons/drag-and-drop.png',
                'difficulty' => 'Easy',
                'reward_coins' => 50,
                'reward_xp' => 20,
                'sort_order' => 2,
            ],
            [
                'title' => 'Word Puzzle',
                'slug' => 'word-puzzle',
                'icon' => 'games/icons/word-puzzle.png',
                'difficulty' => 'Medium',
                'reward_coins' => 100,
                'reward_xp' => 50,
                'sort_order' => 3,
            ],
            [
                'title' => 'Pattern Memory',
                'slug' => 'pattern-memory',
                'icon' => 'games/icons/pattern-memory.png',
                'difficulty' => 'Medium',
                'reward_coins' => 100,
                'reward_xp' => 50,
                'sort_order' => 4,
            ],
            [
                'title' => 'Code Breaker',
                'slug' => 'code-breaker',
                'icon' => 'games/icons/code-breaker.png',
                'difficulty' => 'Hard',
                'reward_coins' => 200,
                'reward_xp' => 100,
                'sort_order' => 5,
            ],
            [
                'title' => 'Sudoku Lite',
                'slug' => 'sudoku-lite',
                'icon' => 'games/icons/sudoku-lite.png',
                'difficulty' => 'Hard',
                'reward_coins' => 200,
                'reward_xp' => 100,
                'sort_order' => 6,
            ],
        ];

        foreach ($games as $game) {
            GameZone::updateOrCreate(
                ['slug' => $game['slug']],
                $game
            );
        }
    }
}

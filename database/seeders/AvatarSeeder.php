<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avatars = [
            [
                'name' => 'panda',
                'image' => 'avatars/panda.png',
                'status' => 1,
            ],
            [
                'name' => 'fox',
                'image' => 'avatars/fox.png',
                'status' => 1,
            ],
            [
                'name' => 'lion',
                'image' => 'avatars/lion.png',
                'status' => 1,
            ],
            [
                'name' => 'frog',
                'image' => 'avatars/frog.png',
                'status' => 1,
            ],
            [
                'name' => 'monkey',
                'image' => 'avatars/monkey.png',
                'status' => 1,
            ],
            [
                'name' => 'tiger',
                'image' => 'avatars/tiger.png',
                'status' => 1,
            ],
        ];

        foreach($avatars as $avatar) {
            Avatar::updateOrCreate(
                ['name' => $avatar['name']],
                $avatar
            );
        }
    }
}

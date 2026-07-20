<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'difficulty',
        'reward_coins',
        'reward_xp',
        'is_active',
        'sort_order',
    ];
    
}

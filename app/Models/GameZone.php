<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GameZone extends Model
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

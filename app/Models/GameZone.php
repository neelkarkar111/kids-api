<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameZone extends Model
{
    use SoftDeletes;

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

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
}

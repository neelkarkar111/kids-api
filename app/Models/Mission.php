<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'title',
        'description',
        'target',
        'reward_coins',
        'reward_xp',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
}

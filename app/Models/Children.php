<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Children extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name', 'age', 
        'gender',
        'avatar', 
        'coins', 
        'xp', 
        'level',
        'progress', 
        'streak', 
        'last_active_date', 
        'completed_missions',
        'today_screen_time', 
        'screen_time_date',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}

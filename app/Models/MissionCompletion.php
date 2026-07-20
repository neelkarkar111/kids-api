<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionCompletion extends Model
{
    protected $fillable = [
        'mission_id',
        'child_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function child()
    {
        return $this->belongsTo(Children::class);
    }
}

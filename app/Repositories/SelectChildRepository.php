<?php

namespace App\Repositories;

class SelectChildRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function select(int $childId) {

        return auth()->user()->children()->findOrFail($childId);
    }
}

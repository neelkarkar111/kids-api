<?php

namespace App\Services;

use App\Repositories\ChildRepository;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ChildRepository $childrepository,
    ) {}

    public function profile() {

    }
}

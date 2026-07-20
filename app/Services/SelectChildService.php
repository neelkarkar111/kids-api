<?php

namespace App\Services;

use App\Repositories\SelectChildRepository;

class SelectChildService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected SelectChildRepository $selectChildRepository,
    ) {}

    public function selectChild(int $childId) {
        return $this->selectChildRepository->select($childId);
    }
}

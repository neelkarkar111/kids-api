<?php

namespace App\Services;

use App\Repositories\ParentRepository;

class ParentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ParentRepository $parentRepository
    ) {}

    public function getAll($perPage = 10)
    {
        return $this->parentRepository->getAll($perPage);
    }

    public function find(int $id)
    {
        return $this->parentRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->parentRepository->update($id, $data);
    }
    
    public function delete(int $id)
    {
        $this->parentRepository->delete($id);
    }
}

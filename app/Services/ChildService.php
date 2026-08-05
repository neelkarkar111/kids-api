<?php

namespace App\Services;

use App\Repositories\ChildRepository;
use Carbon\Carbon;

class ChildService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ChildRepository $childRepository,
    ) {}

    public function all() {

        return $this->childRepository->all();
    }

    public function create(array $data) {

        $today = Carbon::today()->toDateString();

        $data['last_active_date'] = $today;
        $data['screen_time_date'] = $today;

        return $this->childRepository->create($data);
    }

    public function find(int $id) {
        
        return $this->childRepository->find($id);
    }

    public function update(array $data, int $id) {

        return $this->childRepository->update($data, $id);
    } 

    public function delete(int $id) {

        return $this->childRepository->delete($id);
    }
}

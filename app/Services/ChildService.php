<?php

namespace App\Services;

use App\Models\Children;
use App\Repositories\ChildRepository;
use Carbon\Carbon;

class ChildService
{
    public function __construct(    
        protected ChildRepository $childRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Parent
    |--------------------------------------------------------------------------
    */

    public function allByParent() {

        return $this->childRepository->allByParent();
    }

    public function createByParent(array $data) {

        $today = Carbon::today()->toDateString();

        $data['last_active_date'] = $today;
        $data['screen_time_date'] = $today;

        return $this->childRepository->createByParent($data);
    }

    public function findByParent(int $id) {
        
        return $this->childRepository->findByParent($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    public function all(int $perPage = 10) {

        return $this->childRepository->all($perPage);
    }

    public function find(int $id) {

        return $this->childRepository->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Comman
    |--------------------------------------------------------------------------
    */

    public function update(Children $children, array $data) {

        return $this->childRepository->update($children, $data);
    } 

    public function delete(Children $children) {

        return $this->childRepository->delete($children );
    }
}

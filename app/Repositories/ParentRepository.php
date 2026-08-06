<?php

namespace App\Repositories;

use App\Models\User;

class ParentRepository
{
    public function getAll($perPage = 10)
    {
        return User::query()->whereHas('role', function ($query) {
                $query->where('name', 'Parent');
            })
            ->withCount('children')
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id)
    {
        return User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'Parent'))
            ->with(['children.avatar'])
            ->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $parent = $this->find($id);

        $parent->update($data);

        return $parent->fresh();
    }
    public function delete(int $id)
    {
        $parent = $this->find($id);

        $parent->delete();
    }
}

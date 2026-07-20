<?php

namespace App\Interfaces;

interface ChildInterface
{
    public function all();

    public function create(array $data);

    public function find(int $id);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function updateScreenTime(int $id, int $seconds);

}



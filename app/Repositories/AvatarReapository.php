<?php

namespace App\Repositories;

use App\Models\Avatar;

class AvatarReapository
{
    public function index() {
        
        return Avatar::all();
    }

    public function store(array $data) {

        return Avatar::create($data);   
    }

    public function update(Avatar $avatar, array $data) {

        $avatar->update($data);

        return $avatar;
    }

    public function destroy(Avatar $avatar) {

        return $avatar->delete();
    }
}

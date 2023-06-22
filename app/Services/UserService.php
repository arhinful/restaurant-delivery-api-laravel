<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function store(array $data): User{
        $user = User::create($data);
    }
}

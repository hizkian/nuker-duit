<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserRepository
{

    public function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username AND deleted_at IS NULL";

        $result = DB::selectOne($query, ['username' => $username]);

        return $result;
    }
}
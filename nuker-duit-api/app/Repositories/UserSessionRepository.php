<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserSessionRepository
{

    public function getLasUserSession($userId)
    {
        $query = "SELECT * FROM user_sessions WHERE user_id = :user_id AND deleted_at IS NULL ORDER BY id DESC";

        $result = DB::selectOne($query, ['user_id' => $userId]);

        return $result;
    }

    public function createUserSession($userId, $token, $action)
    {
        $query = "INSERT INTO user_sessions (user_id, token, action) VALUES (?, ?, ?)";

        $result = DB::statement($query, [$userId, $token, $action]);

        return $result;
    }
}
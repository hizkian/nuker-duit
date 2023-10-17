<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserSessionRepository
{

    public function getLasUserSession($userId)
    {
        $query = "SELECT * FROM user_sessions WHERE token = :user_id AND deleted_at IS NULL ORDER BY id DESC";

        $result = DB::selectOne($query, ['user_id' => $userId]);

        return $result;
    }

    public function createUserSession($userId, $token, $action)
    {
        $query = "INSERT INTO user_sessions (created_at, updated_at, user_id, token, action) VALUES (NOW(), NOW(), ?, ?, ?)";

        $result = DB::statement($query, [$userId, $token, $action]);

        return $result;
    }

    public function getLasUserSessionByToken($token)
    {
        $query = "SELECT * FROM user_sessions WHERE token = :token AND deleted_at IS NULL ORDER BY id DESC";

        $result = DB::selectOne($query, ['token' => $token]);

        return $result;
    }
}
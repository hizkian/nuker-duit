<?php

namespace App\Services;

use App\Repositories\UserSessionRepository;

class UserSessionService
{
    protected $userSessionsRepository;

    public function __construct(UserSessionRepository $userSessionsRepository)
    {
        $this->userSessionsRepository = $userSessionsRepository;
    }

    public function getLasUserSession(int $userId)
    {
        return $this->userSessionsRepository->getLasUserSession($userId);
    }

    public function createUserSession($userId, $token, $action)
    {
        return $this->userSessionsRepository->createUserSession($userId, $token, $action);
    }
}
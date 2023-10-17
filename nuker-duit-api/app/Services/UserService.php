<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(string $username)
    {
        return $this->userRepository->findByUsername($username);
    }

    public function getUserToken($user)
    {
        $factory = JWTAuth::factory();
        $payload = $factory->customClaims(['sub' => $user->id, 'username' => $user->username])->make();
        $jwtTokenValue = JWTAuth::encode($payload)->get();

        return $jwtTokenValue;
    }
}
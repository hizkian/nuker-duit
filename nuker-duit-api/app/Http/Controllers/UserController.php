<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\UserSessionService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $userService;
    protected $userSessionService;

    public function __construct(UserService $userService, UserSessionService $userSessionService)
    {
        $this->userService = $userService;
        $this->userSessionService = $userSessionService;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $userData = $request->only(['username', 'password']);
        $user = $this->userService->getUser($userData['username']);

        $isPasswordCorrect = ($user && Hash::check($request->input('password'), $user->password));
        if ($isPasswordCorrect) {
            $lastUserSession = $this->userSessionService->getLasUserSession($user->id);

            if ($lastUserSession && $lastUserSession->action == "login") {
                $tokenValue = $lastUserSession->token;

                try {
                    JWTAuth::setToken($tokenValue);
                    $isValid = JWTAuth::check();
                
                    if ($isValid) {
                        return response()->json(['token' => $tokenValue]);
                    }
                } catch (Exception $e) {}
            }

            $tokenValue = $this->userService->getUserToken($user);

            $this->userSessionService->createUserSession($user->id, $tokenValue, "login");

            return response()->json(['token' => $tokenValue]);
        } 

        return response()->json("Invalid credentials", 401);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        JWTAuth::setToken($token);

        $lastUserSession = $this->userSessionService->getLasUserSessionByToken($token);

        if($lastUserSession && $lastUserSession->action == "login") {
            $this->userSessionService->createUserSession($lastUserSession->user_id, $token, "logout");
        }

        return response()->json(['message'=>"success"], 200);
    }
}

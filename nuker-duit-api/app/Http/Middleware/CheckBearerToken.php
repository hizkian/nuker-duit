<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenValue = "";
        $bearerToken = $request->header('Authorization');
        if (Str::startsWith($bearerToken, 'Bearer ')) {
            $tokenValue = Str::substr($bearerToken, 7); // Remove "Bearer " from the token
        }
        
        if($tokenValue == "") {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            JWTAuth::setToken($tokenValue);
            $payload = JWTAuth::check(true);
        
            if (!$payload) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->merge(['userId' => $payload['sub']]);

        return $next($request);
    }
}

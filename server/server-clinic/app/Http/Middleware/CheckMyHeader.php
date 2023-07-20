<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckMyHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-Auth-Token')) {
            $myToken = $request->header('X-Auth-Token');
            Auth::onceUsingId($this->parseToken($myToken));
        }

        return $next($request);
    }
    private function parseToken($myToken)
{
    try {
        $token = JWTAuth::setToken($myToken); 
        $payload = JWTAuth::getPayload($token); 

        return $payload->get('sub'); 
    } catch (JWTException $e) {
        abort(500);
    }
}
}

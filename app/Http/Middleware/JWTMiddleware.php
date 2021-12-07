<?php

namespace CreatyDev\Http\Middleware;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;

use Closure;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error' => 'Token is Invalid'],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error' => 'Token has Expired']);
            }else{
                return response()->json(['error' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}

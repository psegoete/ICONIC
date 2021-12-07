<?php

namespace CreatyDev\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class blockUser
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
        if(auth()->check()) {
            if(auth::user()->role == 'customer' && auth::user()->blocked == '1'){
                if(auth()->check()) {
                    auth::logout();
                    redirect('/')->with('error','Your account has been blocked.');
                    
                }
            }
            return $next($request);
        }else{

            return $next($request);
        }

    }
}

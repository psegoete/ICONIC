<?php

namespace CreatyDev\Http\Middleware;

use Closure;

class CustomerRights
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

            if(auth()->user()->role != 'customer'){
                return redirect()->route('/');
            }
            
         }

        return $next($request);
    }
}

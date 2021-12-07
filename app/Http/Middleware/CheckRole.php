<?php

namespace CreatyDev\Http\Middleware;

use Closure;

class CheckRole
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
            // session()->put('url.intended', $request->url());
            
            if(auth()->user()->role == 'admin'){
                return redirect('admin/dashboard');
            }

            if(auth()->user()->role == 'super-admin'){
                return redirect('super-admin/dashboard');
            }

            if(auth()->user()->role == 'customer'){
                return redirect()->route('dashboard');
            }
            
         }

        return $next($request);
    }
}

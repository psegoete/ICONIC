<?php

namespace CreatyDev\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Company\Models\Company;

use Closure;

class blockCompany
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
        $company =  Company::where('domain_name', '=', request()->getHost())->first();

        if($company){
            if($company->blocked == 1){
                if(auth()->check()) {
                    auth::logout();
                }
                redirect('/')->with('error','This company has been blocked.');
                return $next($request);
            }else{
                return $next($request);
            }
        } 
    }   
}

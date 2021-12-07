<?php

namespace CreatyDev\Http\Middleware;
use CreatyDev\Domain\Company\Models\Company;

use Closure;

class CheckCompany
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
        $company =  Company::where([['domain_name', '=', request()->getHost()],['active', '=' , 1]])->firstOrFail();

        if($company){

            return $next($request);
        }

    }
}

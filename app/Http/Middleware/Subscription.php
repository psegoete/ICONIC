<?php

namespace CreatyDev\Http\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Closure;

class Subscription
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

        $subscription =  DB::table('subscriptions')->where([['company_id','=', checkDomain()]])->orderBy('updated_at', 'desc')->get();

        if($subscription->count()){
            if($subscription[0]->ends_at < \Carbon\Carbon::now()){
                if(Auth::user()->role == 'admin'){
                    return redirect('subscriptions')->with('error', 'You are currently not subscribed.');
                }
            }
        }else{
            return redirect('subscriptions');
        }
        return $next($request);
    }
}

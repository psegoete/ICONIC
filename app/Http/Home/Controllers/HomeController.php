<?php

namespace CreatyDev\Http\Home\Controllers;

use Illuminate\Http\Request;
use CreatyDev\App\Controllers\Controller;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;
use CreatyDev\Domain\Subscriptions\Models\Plan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Log the visitor
        //VisitLog::save();
        // Get Plans to show on the landing page

        $company_credits =  DB::table('company_credits')->orderBy('updated_at', 'desc')->paginate(10);
        $plans =  Plan::take('3')->get();
        return view('home.index', compact(['plans'],['company_credits'] ));
    }
}

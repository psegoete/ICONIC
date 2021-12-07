<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\Order;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Users\Models\User;

class AdminDashboardController extends Controller
{

    public function adminDashboard()
    {

        $file_services =  DB::table('file_services')->where([['file_services.company_id', '=', auth('api')->user()->company_id], ['file_services.status', '=', 'Completed']])
        ->select(DB::raw("CONCAT_WS('-',MONTH(file_services.created_at),YEAR(file_services.created_at)) as monthyear"), DB::raw('COUNT(file_services.id) as total_files'))
        ->groupBy('monthyear')
        ->get();
        $open = FileService::where([['status', '=', 'open'], ['company_id', '=', auth('api')->user()->company_id]])->count();
        $waiting = FileService::where([['status', '=', 'waiting'], ['company_id', '=', auth('api')->user()->company_id]])->count();
        $completed = FileService::where([['status', '=', 'completed'], ['company_id', '=', auth('api')->user()->company_id]])->count();
        $orders =  DB::table('orders')->where([['company_id', '=', auth('api')->user()->company_id]])->orderBy('updated_at', 'desc')->paginate(10);
        $totalOrders =  DB::table('orders')->where([['company_id', '=', auth('api')->user()->company_id]])->orderBy('updated_at', 'desc')->get()->count();
        $total_customers = User::where([['company_id', '=', auth('api')->user()->company_id], ['role', '=', 'customer']])->count();
        // $categories = Category::where('name', '=',  'File service')->firstOrFail();
        $from = \Carbon\Carbon::now()->subMonths(12);
        $to = \Carbon\Carbon::now();
        $category = [];
        $data = [];
        
        
        
        // dd(\Carbon\Carbon::parse()->month(explode("-",'2-2021')[0]));
        
        $credits = CreditsReserve::whereBetween('created_at', [$from, $to])->where([['action', '=', 'tuning'], ['company_id', '=', auth('api')->user()->company_id]])->orderBy('created_at', 'asc')->get();
        
        for ($i = 0; $i < $file_services->count(); $i++) {
            $category[$i] = \Carbon\Carbon::parse()->month(explode("-", $file_services[$i]->monthyear)[0])->format('M') . '-' . \Carbon\Carbon::parse()->year(explode("-", $file_services[$i]->monthyear)[1])->format('Y');
            $data[$i] = $file_services[$i]->total_files;
        }
        
        $tuning = UserTuningCredit::where([['company_id', '=', auth('api')->user()->company_id]])->get();
        $tickets = Ticket::where([['company_id', '=', auth('api')->user()->company_id], ['admin_view_status', '=', 'Open']])->get();
        // return response()->json('ewfwe' );
        return response()->json(['tickets' => $tickets,'orders' => $orders,'open' => $open,'waiting' => $waiting,
        'completed' => $completed,'completed' => $completed,'totalOrders' => $totalOrders,'total_customers' => $total_customers,'category' => $category,'data' => $data],200);
        return response()->json(['tickets'], ['orders'], ['open'], ['waiting'], ['completed'], ['totalOrders'], ['total_customers'], ['category'], ['data'], 200);
    }
}
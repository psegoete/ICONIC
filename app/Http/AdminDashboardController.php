<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\Order;
use CreatyDev\Charts\UsersChart;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Exports\CreditsReservesExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller
{

    public function adminDashboard()
    {


        // $data =  DB::table('file_services')->where([['file_services.company_id','=',checkDomain()],['file_services.status','=','Completed']])
        // ->Join('users','users.id','=','file_services.user_id')
        // ->select('users.id','users.first_name','users.last_name','users.email',DB::raw("CONCAT_WS('-',MONTH(file_services.created_at),YEAR(file_services.created_at)) as monthyear"),'users.updated_at','users.activated','users.blocked',DB::raw('COUNT(file_services.id) as total_files'))
        // ->groupBy('users.id','users.first_name','users.last_name','users.email','monthyear','users.updated_at','users.activated','users.blocked')
        // ->get();
        // dd($data);
        $from = \Carbon\Carbon::now()->subMonths(12);
        $to = \Carbon\Carbon::now();
        $file_services =  DB::table('file_services')->whereBetween('created_at', [$from, $to])->where([['file_services.company_id', '=', checkDomain()], ['file_services.status', '=', 'Completed']])
            ->select(DB::raw("CONCAT_WS('-',MONTH(file_services.created_at),YEAR(file_services.created_at)) as monthyear"), DB::raw('COUNT(file_services.id) as total_files'))
            ->groupBy('monthyear')
            ->orderBy('file_services.created_at')
            ->get();
        // dd($file_services);
        $open = FileService::where([['status', '=', 'open'], ['company_id', '=', checkDomain()]])->count();
        $waiting = FileService::where([['status', '=', 'waiting'], ['company_id', '=', checkDomain()]])->count();
        $completed = FileService::where([['status', '=', 'completed'], ['company_id', '=', checkDomain()]])->count();
        $orders =  DB::table('orders')->where([['company_id', '=', checkDomain()]])->orderBy('updated_at', 'desc')->paginate(10);
        $totalOrders =  DB::table('orders')->where([['company_id', '=', checkDomain()]])->orderBy('updated_at', 'desc')->get()->count();
        $total_customers = User::where([['company_id', '=', checkDomain()], ['role', '=', 'customer']])->count();
        // $categories = Category::where('name', '=',  'File service')->firstOrFail();

        
        $category = [];
        $data = [];
        

        // dd(\Carbon\Carbon::parse()->month(explode("-",'2-2021')[0]));

        $credits = CreditsReserve::whereBetween('created_at', [$from, $to])->where([['action', '=', 'tuning'], ['company_id', '=', checkDomain()]])->orderBy('created_at', 'asc')->get();

        for ($i = 0; $i < $file_services->count(); $i++) {
            $category[$i] = \Carbon\Carbon::parse()->month(explode("-",$file_services[$i]->monthyear)[0])->format('M').'-'.\Carbon\Carbon::parse()->year(explode("-",$file_services[$i]->monthyear)[1])->format('Y');
            $data[$i] = $file_services[$i]->total_files;
        }

        $tuning = UserTuningCredit::where([['company_id', '=', checkDomain()]])->get();
        $tickets = Ticket::where([['company_id', '=', checkDomain()], ['admin_view_status', '=', 'Open']])->get();
        return view('dashboards.dashboard', compact(['tickets'], ['orders'], ['open'], ['waiting'], ['completed'], ['totalOrders'], ['total_customers'], ['category'], ['data']));
    }

    function export(Request $request){
        // dd($request->input());
        $from = \Carbon\Carbon::parse($request->input('start'));
        $to = \Carbon\Carbon::parse($request->input('end'));
        return Excel::download(new CreditsReservesExport($from,$to), 'report.xlsx');
    }
}

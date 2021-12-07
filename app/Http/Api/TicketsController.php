<?php

// namespace CreatyDev\Http\Ticket\Controllers;
namespace CreatyDev\Http\api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Ticket\Mail\SendTicket;
use CreatyDev\Domain\Ticket\Models\Category;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use CreatyDev\Domain\tuningType;
use CreatyDev\Domain\ReadMethod;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\UserDevice;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Gearboxe;
use CreatyDev\Domain\FileShareCredit;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Ticket\Models\Comment;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\MailHistory;


class TicketsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (auth('api')->user()->role == 'admin') {
            $openTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.admin_view_status', '=', 'Open']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();
            $closedTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.admin_view_status', '=', 'Closed']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();
            $allTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id]])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();


            if ($request->input('search')) {
                $tickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.admin_view_status', '=', $request->input('search')]])
                    ->join('categories', 'categories.id', '=', 'tickets.category_id')
                    ->join('users', 'users.id', '=', 'tickets.user_id')
                    ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                    ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name as category')
                    ->get();
            } else {
                $tickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id]])
                    ->join('categories', 'categories.id', '=', 'tickets.category_id')
                    ->join('users', 'users.id', '=', 'tickets.user_id')
                    ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                    ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                    ->get();
            }

            return response()->json(['tickets' => $tickets, 'openTickets' => $openTickets, 'closedTickets' => $closedTickets, 'allTickets' => $allTickets], 200);
        } else if (auth('api')->user()->role == 'customer') {
            $openTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.user_id', '=', auth('api')->user()->id], ['tickets.customer_view_status', '=', 'Open']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            $closedTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.user_id', '=', auth('api')->user()->id], ['tickets.customer_view_status', '=', 'Closed']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            $allTickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.user_id', '=', auth('api')->user()->id]])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            if ($request->input('search')) {
                $tickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.user_id', '=', auth('api')->user()->id], ['tickets.customer_view_status', '=', $request->input('search')]])
                    ->join('categories', 'categories.id', '=', 'tickets.category_id')
                    ->join('users', 'users.id', '=', 'tickets.user_id')
                    ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                    ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name as category')
                    ->get();
            } else {
                $tickets =  DB::table('tickets')->where([['tickets.company_id', '=', auth('api')->user()->company_id], ['tickets.user_id', '=', auth('api')->user()->id]])
                    ->join('categories', 'categories.id', '=', 'tickets.category_id')
                    ->join('users', 'users.id', '=', 'tickets.user_id')
                    ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                    ->orderBy('updated_at', 'desc')
                    ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name as category')
                    ->get();
            }

            return response()->json(['tickets' => $tickets, 'openTickets' => $openTickets, 'closedTickets' => $closedTickets, 'allTickets' => $allTickets], 200);
        }
    }

    public function customerFileserviceTickets(Request $request, $id)
    {
        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tunner = User::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_type =  tuningType::where([['id', '=', $file_service->tuning_type]])->firstOrFail();
        $tuning_optionsArray = array();


        if ($file_service->tuning_options) {
            foreach (explode(',', $file_service->tuning_options) as $array) {
                array_push($tuning_optionsArray, (int)$array);
            }
        }

        $tuning_options =  DB::table('tuning_options')->whereIn('id', $tuning_optionsArray)->get();

        $readmethod =  ReadMethod::where([['id', '=', $file_service->read_method]])->firstOrFail();
        $gearbox =  Gearboxe::where([['id', '=', $file_service->gearbox]])->firstOrFail();

        if (auth('api')->user()->role == 'admin') {
            $ticket = Ticket::where([['company_id', '=', auth('api')->user()->company_id], ['file_service_id', '=', $id]])->firstOrFail();
        } else if (auth('api')->user()->role == 'customer') {
            $ticket = Ticket::where([['company_id', '=', auth('api')->user()->company_id], ['user_id', '=', auth('api')->user()->id], ['file_service_id', '=', $id]])->firstOrFail();
        }

        return response()->json(['ticket' => $ticket, 'gearbox' => $gearbox, 'readmethod' => $readmethod, 'tuning_options' => $tuning_options, 'tuning_type' => $tuning_type, 'tunner' => $tunner, 'file_service' => $file_service], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $file_services =  FileService::where([['company_id', '=', auth('api')->user()->company_id]])->whereIn('user_id', [auth('api')->user()->id])->orderBy('updated_at', 'desc')->get();
        return response()->json(['categories' => $categories, 'file_services' => $file_services], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $categories = Category::where('id', '=',  $request->input('category_id'))->firstOrFail();

        if ($categories->name == 'General question') {
            $subject =  $request->input('subject');
            $email_subject = 'A new ticket has been created';
            $file_service_id = null;
            $this->validate($request, [
                'category_id' => 'required',
                'subject' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'category_id' => 'required',
                'file_service_id' => 'required',
            ]);
            $file_service = FileService::where([['id', '=', $request->input('file_service_id')], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $file_service_id = $file_service->id;
            $subject = $file_service->model . ' ' . $file_service->make . ' ' . $file_service->engine;
            $email_subject = 'New file service has been submitted';
        }

        if($file_service_id){
            $ticket = Ticket::where([['file_service_id', '=', $request->input('file_service_id')], ['company_id', '=', auth('api')->user()->company_id]])->first();
            if($ticket){

            }else{
                $ticket = new Ticket([
                    'subject' => $subject,
                    'user_id' => auth('api')->user()->id,
                    'ticket_id' => strtoupper(Str::random(10)),
                    'category_id' => $request->input('category_id'),
                    'file_service_id' => $file_service_id,
                    'status' => "Open",
                    'company_id' => auth('api')->user()->company_id,
                ]);
            }
        }else{
            $ticket = new Ticket([
                'subject' => $subject,
                'user_id' => auth('api')->user()->id,
                'ticket_id' => strtoupper(Str::random(10)),
                'category_id' => $request->input('category_id'),
                'file_service_id' => $file_service_id,
                'status' => "Open",
                'company_id' => auth('api')->user()->company_id,
            ]);
        }



        $ticket->customer_view_status = "Open";
        $ticket->customer_viewed_status = 'Open';
        $ticket->admin_view_status = "Open";

        $ticket->save();


        $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
        $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $data = [
            'company_name' => $company->company_name,
            'admin_name' =>  $admin->name,
            'admin_email' =>  $admin->email,
            'name' =>  $customer->name,
            'email' =>  $customer->email,
            'subject' =>  $email_subject,
            'id' =>  $ticket->ticket_id,
            'from' => $company->company_email,
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
            'message_subject' =>  $categories->name . ' - ' . $subject,
            'message' =>  $request->input('message'),
        ];

        $comment = new Comment([
            'ticket_id' => $ticket->id,
            'user_id' => auth('api')->user()->id,
            'user_comment_id' => auth('api')->user()->id,
            'company_id' => auth('api')->user()->company_id,
        ]);

        if ($request->input('message')) {
            $comment->comment = $request->input('message');
        }
        if ($request->file('comment_file')) {
            $name = $request->file('comment_file')->hashName();
            $request->file('comment_file')->move(base_path('public/uploads'), $name);
            $comment->file_name = $name;
            $comment->file_name_title = $request->file('comment_file')->getClientOriginalName();
            if ($company->plan != 'enterprice') {
                $credits = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }
        }

        // $headers = array(
        //     'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
        //     'Content-Type: application/json'
        // );

        $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

        foreach ($devices as $key => $value) {

            if ($request->input('message') || $request->file('comment_file')) {
                $comment->save();
                pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth('api')->user()->name . ' - ' . $categories->name);
            } else {

                pushNotification($value->device_id, $subject, auth('api')->user()->name . ' - ' . $categories->name);
            }
        }







        #Send Reponse To FireBase Server    


        // Mail::send('emails.new_customer_ticket', ['data' => $data], function ($m) use ($data) {
        //     $m->from($data['from'], $data['company_name']);

        //     $m->to($data['admin_email'], $data['company_name'])->subject('New file service');
        // });

        $mail_history = new MailHistory([
            'seen' => 0,
            'from' => $company->company_email,
            'user_id' => $ticket->user_id,
            // 'file_service_id' => $file_service->id,
            'comment_id' => $comment->id,
            'ticket_id' => $ticket->id,
            'subject' => $email_subject,
            'email_type' => 'new_support_ticket',
            // 'sent' => checkDomain(),
            // 'amount' => checkDomain(),
            'company_id' => auth('api')->user()->company_id,
            // 'token' => auth('api')->user()->company_id,
        ]);
        $mail_history->save();

        return response()->json(['success' => 'A ticket with ID: #' . $ticket->ticket_id . ' has been opened.', 'ticket_id' => $ticket->ticket_id], 200);
    }

    public function userTickets()
    {
        $categories = Category::all();
        $tickets = Ticket::where('user_id', auth('api')->user()->id)->paginate(10);

        return response()->json(['categories' => $categories, 'tickets' => $tickets], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $categories = Category::where('id', '=', $ticket->category_id)->firstOrFail();
        // return response()->json(['categories' => $categories]);

        if ($categories->name == 'General question') {
            $file_service = '';
            $tuning_type = '';
            $readmethod = '';
            $gearbox = '';
            $tuning_options = '';
        } else {
            $file_service = FileService::where([['id', '=', $ticket->file_service_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $tuning_type =  tuningType::where([['id', '=', $file_service->tuning_type]])->firstOrFail();
            $tuning_optionsArray = array();

            if ($file_service->tuning_options) {
                foreach (explode(',', $file_service->tuning_options) as $array) {
                    array_push($tuning_optionsArray, (int)$array);
                }
            }
            $readmethod =  ReadMethod::where([['id', '=', $file_service->read_method], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $gearbox =  Gearboxe::where([['id', '=', $file_service->gearbox], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $tuning_options =  DB::table('tuning_options')->whereIn('id', $tuning_optionsArray)->get();
        }

        $tunner = User::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        if (auth('api')->user()->role == 'customer') {
            $ticket->customer_viewed_status = 'Closed';
            $ticket->save();
        }

        return response()->json(['ticket' => $ticket, 'gearbox' => $gearbox, 'readmethod' => $readmethod, 'tuning_options' => $tuning_options, 'tuning_type' => $tuning_type, 'tunner' => $tunner, 'file_service' => $file_service, 'categories' => $categories], 200);
    }

    // Show single ticket on admin panel
    public function adminshow($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        return response()->json(['ticket' => $ticket], 200);
    }

    public function close($ticket_id, SendTicket $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = "Closed";

        $ticket->save();

        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("status", "The ticket has been closed.");
    }

    //Tickt form for admin
    public function fileserviceTicketCreate($id)
    {

        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tunner = User::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_type =  tuningType::where([['id', '=', $file_service->tuning_type]])->firstOrFail();
        $tuning_optionsArray = array();


        if ($file_service->tuning_options) {
            foreach (explode(',', $file_service->tuning_options) as $array) {
                array_push($tuning_optionsArray, (int)$array);
            }
        }

        $tuning_options =  DB::table('tuning_options')->whereIn('id', $tuning_optionsArray)->get();

        $readmethod =  ReadMethod::where([['id', '=', $file_service->read_method], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $gearbox =  Gearboxe::where([['id', '=', $file_service->gearbox], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $categories = Category::all();

        return response()->json(['gearbox' => $gearbox, 'readmethod' => $readmethod, 'tuning_options' => $tuning_options, 'tuning_type' => $tuning_type, 'tunner' => $tunner, 'file_service' => $file_service, 'categories' => $categories], 200);
    }

    public function fileserviceCreateTicket($id)
    {

        $categories = Category::all();
        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $category_id = Category::where('name', '=', 'File service')->firstOrFail()->id;

        return response()->json(['categories' => $categories, 'file_service' => $file_service, 'category_id' => $category_id], 200);
    }

    //Admin creates ticket from file service

    public function ticketCreate(Request $request)
    {

        if (companyPlan() != 'enterprice') {
            $credits = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->first();

            if (auth('api')->user()->role == 'admin') {
                if ($credits->credits < 1) {
                    return response()->json(['error' => 'Insufficient sharing credits. Please buy sharing credits.'], 401);
                }
            }
        }

        $categories = Category::where('name', '=', 'File service')->firstOrFail();
        $file_service = FileService::where([['id', '=', $request->file_service_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $tickets = Ticket::where('file_service_id', '=', $file_service->id)->first();

        if ($tickets) {
            $ticket = $tickets;
        } else {

            $ticket = new Ticket([
                'user_id' => $file_service->user_id,
                'ticket_id' => strtoupper(Str::random(10)),
                'category_id' => $categories->id,
                'subject' => $file_service->model . ' ' .  $file_service->make . ' ' .  $file_service->engine,
                'file_service_id' => $request->file_service_id,
                'status' => "Open",
                'company_id' => auth('api')->user()->company_id
            ]);
            $ticket->customer_view_status = "Open";
            $ticket->customer_viewed_status = 'Open';
            $ticket->admin_view_status = "Open";

            $ticket->save();
        }



        $comment = new Comment([
            'ticket_id' => $ticket->id,
            'user_id' => $file_service->user_id,
            'user_comment_id' => auth('api')->user()->id,
            'company_id' => auth('api')->user()->company_id,
        ]);

        if ($request->input('message')) {
            $comment->comment = $request->input('message');
        }

        if ($request->file('file_name')) {
            // $request->file('file_name')->store('public/uploads');
            $name = $request->file('file_name')->hashName();
            $request->file('file_name')->move(base_path('public/uploads'), $name);
            $comment->file_name = $name;
            $comment->file_name_title = $request->file('file_name')->getClientOriginalName();
            if (companyPlan() != 'enterprice') {
                $credits = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }
        }
        // $headers = array(
        //     'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
        //     'Content-Type: application/json'
        // );

        if (auth('api')->user()->role == 'customer') {
            $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
            $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

            $data = [
                'company_name' => $company->company_name,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'id' =>  $ticket->ticket_id,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
                'message' =>  $request->input('message'),
            ];

            $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('message') || $request->file('file_name')) {
                    $comment->save();
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $comment->comment . ' ' . $comment->file_name,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth('api')->user()->name . ' - ' . $categories->name);
                } else {
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $ticket->subject,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $ticket->subject, auth('api')->user()->name . ' - ' . $categories->name);
                }
            }

            // Mail::send('emails.new_support_ticket', ['data' => $data], function ($m) use ($data) {
            //     $m->from($data['from'], $data['company_name']);

            //     $m->to($data['admin_email'], $data['company_name'])->subject('New file service');
            // });


            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $admin->id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'Your ticket has been updated',
                'email_type' => 'new_support_ticket',
                // 'sent' => auth('api')->user()->company_id,
                // 'amount' => checkDomain(),
                'company_id' => auth('api')->user()->company_id,
                // 'token' => auth('api')->user()->company_id,
            ]);
            $mail_history->save();
        }

        if (auth('api')->user()->role == 'admin') {
            $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
            $customer = User::where([['id', '=', auth('api')->user()->id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

            $data = [
                'company_name' => $company->company_name,
                'admin_name' =>  $admin->name,
                'admin_email' =>  $admin->email,
                'name' =>  $customer->name,
                'email' =>  $customer->email,
                'id' =>  $ticket->ticket_id,
                'from' => $company->company_email,
                'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
                'message_subject' =>  $categories->name . ' - ' . $file_service->make . ' ' . $file_service->model . ' ' . $file_service->generation . ' ' . $file_service->engine,
                'message' =>  $request->input('message'),
            ];

            // Mail::send('emails.new_customer_ticket', ['data' => $data], function ($m) use ($data) {
            //     $m->from($data['from'], $data['company_name']);

            //     $m->to($data['email'], $data['company_name'])->subject('New file service');
            // });

            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', auth('api')->user()->company_id]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('message') || $request->file('file_name')) {
                    $comment->save();
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $comment->comment . ' ' . $comment->file_name,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);

                    pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth('api')->user()->ticket_display_name . ' - ' . $categories->name);
                } else {
                    // $fields = array(
                    //     'to' => $value->device_id,
                    //     'notification' => array(
                    //         'body' => $ticket->subject,
                    //         'title' => auth('api')->user()->name . ' - ' . $categories->name,
                    //         'icon'  => 'myicon',/*Default Icon*/
                    //         'sound' => 'mySound'/*Default sound*/
                    //     )
                    // );
                    // $ch = curl_init();
                    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    // curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    // $result = curl_exec($ch);
                    // curl_close($ch);
                    pushNotification($value->device_id, $ticket->subject, auth('api')->user()->ticket_display_name . ' - ' . $categories->name);
                }
            }


            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $ticket->user_id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'Your ticket has been updated',
                'email_type' => 'new_support_ticket',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => auth('api')->user()->company_id,
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        }

        // if ($request->input('message') || $request->file('file_name')) {
        //     $comment->save();
        // }

        return response()->json(['success' => 'The ticket has been created.', 'ticket_id' => $ticket->ticket_id], 401);
    }

    public function category($category_name)
    {
        $category = Category::where('name', '=', $category_name)->firstOrFail();
        return response()->json(['category' => $category], 200);
    }
}

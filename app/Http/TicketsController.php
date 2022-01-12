<?php

// namespace CreatyDev\Http\Ticket\Controllers;
namespace CreatyDev\Http;

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
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Gearboxe;
use CreatyDev\Domain\FileShareCredit;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\UserDevice;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Ticket\Models\Comment;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\MailHistory;


class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()) {
                return redirect('/');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $openTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.admin_view_status', '=', 'Open']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();
            $closedTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.admin_view_status', '=', 'Closed']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();
            $allTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()]])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();



            if ($request->ajax()) {
                if ($request->input('search')) {
                    $data =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.admin_view_status', '=', $request->input('search')]])
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('users', 'users.id', '=', 'tickets.user_id')
                        ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->get();
                } else {
                    $data =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()]])
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('users', 'users.id', '=', 'tickets.user_id')
                        ->groupBy('users.id', 'tickets.id', 'tickets.admin_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->select('tickets.id as id', 'tickets.admin_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->get();
                }

                return response()->json(['data' => $data]);
            }

            return view('tickets.index', compact(['openTickets'], ['closedTickets'], ['allTickets']));
        } else if (Auth::user()->role == 'customer') {
            $openTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.user_id', '=', Auth::user()->id], ['tickets.customer_view_status', '=', 'Open']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            $closedTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.user_id', '=', Auth::user()->id], ['tickets.customer_view_status', '=', 'Closed']])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            $allTickets =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.user_id', '=', Auth::user()->id]])
                ->join('categories', 'categories.id', '=', 'tickets.category_id')
                ->join('users', 'users.id', '=', 'tickets.user_id')
                ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                ->get()->count();

            if ($request->ajax()) {
                if ($request->input('search')) {
                    $data =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.user_id', '=', Auth::user()->id], ['tickets.customer_view_status', '=', $request->input('search')]])
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('users', 'users.id', '=', 'tickets.user_id')
                        ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->get();
                    return response()->json(['data' => $data]);
                } else {
                    $data =  DB::table('tickets')->where([['tickets.company_id', '=', checkDomain()], ['tickets.user_id', '=', Auth::user()->id]])
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('users', 'users.id', '=', 'tickets.user_id')
                        ->groupBy('users.id', 'tickets.id', 'tickets.customer_view_status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->select('tickets.id as id', 'tickets.customer_view_status as status', 'tickets.ticket_id', 'tickets.subject', 'tickets.created_at', 'tickets.updated_at', 'users.first_name', 'users.last_name', 'categories.name')
                        ->get();
                    return response()->json(['data' => $data]);
                }
            }
            return view('tickets.customer', compact(['openTickets'], ['closedTickets'], ['allTickets']));
        }
    }

    public function customerFileserviceTickets(Request $request, $id)
    {

        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $tunner = User::where([['company_id', '=', checkDomain()]])->firstOrFail();
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

        if (Auth::user()->role == 'admin') {
            $ticket = Ticket::where([['company_id', '=', checkDomain()], ['file_service_id', '=', $id]])->firstOrFail();
        } else if (Auth::user()->role == 'customer') {
            $ticket = Ticket::where([['company_id', '=', checkDomain()], ['user_id', '=', Auth::user()->id], ['file_service_id', '=', $id]])->firstOrFail();
        }

        return view('tickets.show', compact(['ticket'], ['gearbox'], ['readmethod'], ['tuning_options'], ['tuning_type'], ['tunner'], ['file_service']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $file_services = FileService::where([['user_id', '=', Auth::user()->id], ['company_id', '=', checkDomain()]])->get();

        return view('tickets.create', compact(['categories'], ['file_services']));
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
            $file_service = FileService::where([['id', '=', $request->input('file_service_id')], ['company_id', '=', checkDomain()]])->firstOrFail();
            $file_service_id = $file_service->id;
            $subject = $file_service->model . ' ' . $file_service->make . ' ' . $file_service->engine;
            $email_subject = 'New file service has been submitted';
        }



        $ticket = new Ticket([
            'subject' => $subject,
            'user_id' => Auth::user()->id,
            'ticket_id' => strtoupper(Str::random(10)),
            'category_id' => $request->input('category_id'),
            'file_service_id' => $file_service_id,
            'status' => "Open",
            'company_id' => checkDomain(),
        ]);

        $ticket->customer_view_status = "Open";
        $ticket->customer_viewed_status = 'Open';
        $ticket->admin_view_status = "Open";

        $ticket->save();


        $company = Company::where('id', '=', \checkDomain())->firstOrFail();
        $customer = User::where([['id', '=', Auth::user()->id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();

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

        // Mail::send('emails.new_support_ticket', ['data' => $data], function ($m) use ($data) {
        //     $m->from($data['from'], $data['company_name']);

        //     $m->to($data['admin_email'], $data['company_name'])->subject($data['subject']);
        // });

        $comment = new Comment([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::user()->id,
            'user_comment_id' => Auth::user()->id,
            'company_id' => checkDomain(),
        ]);

        if ($request->input('message')) {
            $comment->comment = $request->input('message');
        }

        if ($request->file('comment_file')) {
            // $request->file('comment_file')->store('public/uploads');
            $name = $request->file('comment_file')->hashName();
            $request->file('comment_file')->move(base_path('public/uploads'), $name);
            $comment->file_name = $name;
            $comment->file_name_title = $request->file('comment_file')->getClientOriginalName();
            if (companyPlan() != 'enterprice') {
                $credits = UserCompanyCredit::where([['company_id', '=', checkDomain()]])->firstOrFail();
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }
        }


        if ($request->input('message') || $request->file('comment_file')) {
            $comment->save();
        }

        $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', checkDomain()]])->get();

        foreach ($devices as $key => $value) {

            if ($request->input('message') || $request->file('comment_file')) {
                pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth()->user()->name . ' - ' . $categories->name);
            } else {
                pushNotification($value->device_id, $subject, auth()->user()->name . ' - ' . $categories->name);
            }
        }

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
            'company_id' => checkDomain(),
            // 'token' => checkDomain(),
        ]);
        $mail_history->save();

        return redirect('tickets')->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

    public function userTickets()
    {
        $categories = Category::all();
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);

        return view('tickets.user_tickets', compact('tickets', 'categories'));
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

        if ($categories->name == 'General question') {
            $file_service = '';
            $tuning_type = '';
            $readmethod = '';
            $gearbox = '';
            $tuning_options = '';
        } else {
            $file_service = FileService::where([['id', '=', $ticket->file_service_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $tuning_type =  tuningType::where([['id', '=', $file_service->tuning_type]])->firstOrFail();
            $tuning_optionsArray = array();

            if ($file_service->tuning_options) {
                foreach (explode(',', $file_service->tuning_options) as $array) {
                    array_push($tuning_optionsArray, (int)$array);
                }
            }
            $readmethod =  ReadMethod::where([['id', '=', $file_service->read_method]])->firstOrFail();
            $gearbox =  Gearboxe::where([['id', '=', $file_service->gearbox]])->firstOrFail();
            $tuning_options =  DB::table('tuning_options')->whereIn('id', $tuning_optionsArray)->get();
        }

        $tunner = User::where([['company_id', '=', checkDomain()]])->firstOrFail();

        if (Auth::user()->role == 'customer') {
            $ticket->customer_viewed_status = 'Closed';
            $ticket->save();
        }




        return view('tickets.show', compact(['ticket'], ['file_service'], ['gearbox'], ['readmethod'], ['tuning_options'], ['tuning_type'], ['tunner'], ['categories']));
    }

    // Show single ticket on admin panel
    public function adminshow($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        return view('admin.tickets.show', compact('ticket'));
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



        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $tunner = User::where([['company_id', '=', checkDomain()]])->firstOrFail();
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
        $categories = Category::all();

        // dd($file_service);

        return view('tickets.fileserviceTicketCreate', compact(['gearbox'], ['readmethod'], ['tuning_options'], ['tuning_type'], ['tunner'], ['categories'], ['file_service']));
    }

    public function fileserviceCreateTicket($id)
    {

        $categories = Category::all();
        $file_service = FileService::where([['id', '=', $id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $category_id = Category::where('name', '=', 'File service')->firstOrFail()->id;

        return view('tickets.fileserviceCreateTicket', compact(['categories'], ['file_service'], ['category_id']));
    }

    //Admin creates ticket from file service

    public function ticketCreate(Request $request)
    {

        if (companyPlan() != 'enterprice') {
            $credits = UserCompanyCredit::where([['company_id', '=', checkDomain()]])->first();

            if (Auth::user()->role == 'admin') {
                if ($credits->credits < 1) {
                    return redirect()->back()->with("error", "Insufficient sharing credits. Please buy sharing credits.");
                }
            }
        }

        $categories = Category::where('name', '=', 'File service')->firstOrFail();
        $file_service = FileService::where([['id', '=', $request->file_service_id], ['company_id', '=', checkDomain()]])->firstOrFail();

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
                'company_id' => checkDomain()
            ]);
            $ticket->customer_view_status = "Open";
            $ticket->customer_viewed_status = 'Open';
            $ticket->admin_view_status = "Open";

            $ticket->save();
        }



        $comment = new Comment([
            'ticket_id' => $ticket->id,
            'user_id' => $file_service->user_id,
            'user_comment_id' => Auth::user()->id,
            'company_id' => checkDomain(),
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
                $credits = UserCompanyCredit::where([['company_id', '=', checkDomain()]])->firstOrFail();
                $credits->credits = $credits->credits - 1;
                $credits->save();
            }
        }

        if (Auth::user()->role == 'customer') {
            $company = Company::where('id', '=', \checkDomain())->firstOrFail();
            $customer = User::where([['id', '=', Auth::user()->id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();

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

            // Mail::send('emails.new_support_ticket', ['data' => $data], function ($m) use ($data) {
            //     $m->from($data['from'], $data['company_name']);

            //     $m->to($data['admin_email'], $data['company_name'])->subject('New file service');
            // });

            $devices = UserDevice::where([['user_id', '=', $admin->id], ['company_id', '=', checkDomain()]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('message') || $request->file('file_name')) {
                    $comment->save();
                    pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth()->user()->name . ' - ' . $categories->name);
                } else {
                    pushNotification($value->device_id, $ticket->subject, auth()->user()->name . ' - ' . $categories->name);
                }
            }


            $mail_history = new MailHistory([
                'seen' => 0,
                'from' => $company->company_email,
                'user_id' => $admin->id,
                // 'file_service_id' => $file_service->id,
                'comment_id' => $comment->id,
                'ticket_id' => $ticket->id,
                'subject' => 'Your ticket has been updated',
                'email_type' => 'new_support_ticket',
                // 'sent' => checkDomain(),
                // 'amount' => checkDomain(),
                'company_id' => checkDomain(),
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();
        }

        if (Auth::user()->role == 'admin') {
            $company = Company::where('id', '=', \checkDomain())->firstOrFail();
            $customer = User::where([['id', '=', $file_service->user_id], ['company_id', '=', checkDomain()]])->firstOrFail();
            $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();

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

            //     $m->to($data['admin_email'], $data['company_name'])->subject('New file service');
            // });


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
                'company_id' => checkDomain(),
                // 'token' => checkDomain(),
            ]);
            $mail_history->save();

            $devices = UserDevice::where([['user_id', '=', $customer->id], ['company_id', '=', checkDomain()]])->get();

            foreach ($devices as $key => $value) {
    
                if ($request->input('message') || $request->file('file_name')) {
                    pushNotification($value->device_id, $comment->comment . ' ' . $comment->file_name_title, auth()->user()->ticket_display_name . ' - ' . $categories->name);
                } else {
                    pushNotification($value->device_id, $ticket->subject, auth()->user()->ticket_display_name . ' - ' . $categories->name);
                }
            }
        }

        if ($request->input('message') || $request->file('file_name')) {
            $comment->save();
        }

       


        return redirect('tickets/' . $ticket->ticket_id)->with("status", "The ticket has been created.");
    }
}

<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Users\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use CreatyDev\Domain\Availability;
use CreatyDev\Domain\LegalDocument;
use CreatyDev\Domain\PlatformSetting;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\News;
use CreatyDev\Domain\CreditGroup;
use CreatyDev\Charts\UsersChart;
use CreatyDev\Domain\MailTemplate;
use CreatyDev\Domain\MailHistory;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $data =  DB::table('users')->where([['users.company_id', '=', checkDomain()], ['users.role', '=', 'customer']])
                    ->leftJoin('user_tuning_credits', 'users.id', '=', 'user_tuning_credits.user_id')
                    ->leftJoin('file_services', 'users.id', '=', 'file_services.user_id')
                    ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.updated_at', 'users.activated', 'users.blocked', 'user_tuning_credits.credits', DB::raw('COUNT(file_services.id) as total_files'))
                    ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.updated_at', 'users.activated', 'users.blocked', 'user_tuning_credits.credits')
                    ->get();
                return response()->json(['data' => $data]);
            }
        }

        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.dashboard');
    }

    public function dashboard()
    {

        $Availability = Availability::where('company_id', '=', checkDomain())->firstOrFail();
        $PlatformSetting = PlatformSetting::where('company_id', '=', checkDomain())->firstOrFail();
        $LegalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $news =  DB::table('news')->where([['company_id', '=', checkDomain()]])->orderBy('updated_at', 'desc')->paginate(10);

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Mon') {
            if ($Availability->monday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->monday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->monday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->monday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->monday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Tue') {
            if ($Availability->tuesday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->tuesday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->tuesday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->tuesday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->tuesday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Wed') {
            if ($Availability->wednesday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->wednesday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->wednesday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->wednesday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->wednesday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Thu') {
            if ($Availability->thursday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->thursday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->thursday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->thursday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->thursday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Fri') {
            if ($Availability->friday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->friday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->friday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->friday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->friday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Sat') {
            if ($Availability->saturday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->saturday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->saturday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->saturday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->saturday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        if (\Carbon\Carbon::now()->isoFormat('ddd') == 'Sun') {
            if ($Availability->sunday_status == 1) {
                $status = 'CLOSED';
            } else {
                if (\Carbon\Carbon::now()->isoFormat('H') >= \Carbon\Carbon::parse($Availability->sunday_opening_time)->isoFormat('H') && \Carbon\Carbon::now()->isoFormat('H') <= \Carbon\Carbon::parse($Availability->sunday_closing_time)->isoFormat('H')) {
                    if (\Carbon\Carbon::now()->isoFormat('H') == \Carbon\Carbon::parse($Availability->sunday_closing_time)->isoFormat('H')) {
                        if (\Carbon\Carbon::now()->isoFormat('m') < \Carbon\Carbon::parse($Availability->sunday_closing_time)->isoFormat('m')) {
                            $status = 'OPEN';
                        } else {
                            $status = 'CLOSED';
                        }
                    } else {
                        $status = 'OPEN';
                    }
                } else {
                    $status = 'CLOSED';
                }
            }
        }

        $file_services1 =  DB::table('file_services')->where([['file_services.company_id', '=', checkDomain()], ['file_services.status', '=', 'Completed'],['file_services.user_id', '=', auth()->user()->id]])
            ->select(DB::raw("CONCAT_WS('-',MONTH(file_services.created_at),YEAR(file_services.created_at)) as monthyear"), DB::raw('COUNT(file_services.id) as total_files'))
            ->groupBy('monthyear')
            ->get();

            $category = [];
            $data = [];

            for ($i = 0; $i < $file_services1->count(); $i++) {
                $category[$i] = \Carbon\Carbon::parse()->month(explode("-",$file_services1[$i]->monthyear)[0])->format('M').'-'.\Carbon\Carbon::parse()->year(explode("-",$file_services1[$i]->monthyear)[1])->format('Y');
                $data[$i] = $file_services1[$i]->total_files;
            }

        return view('customers.dashboard', compact(['Availability'], ['PlatformSetting'], ['LegalDocument'], ['company'], ['news'], ['status'], ['category'], ['data']));
    }



    public function admindashboard()
    {

        $total_customers = User::where([['role', '=', 'admin']])->count();
        $company = Company::all();


        $from = \Carbon\Carbon::now()->subMonths(12);
        $to = \Carbon\Carbon::now();
        $category = [];
        $data = [];

        $file_services =  CreditsReserve::whereBetween('created_at', [$from, $to])->where([['action', '=', 'company'],['status', '=', 1]])
            ->select(DB::raw("CONCAT_WS('-',MONTH(credits_reserves.created_at),YEAR(credits_reserves.created_at)) as monthyear"), DB::raw('COUNT(credits_reserves.id) as total_files'))
            ->groupBy('monthyear')
            ->orderBy('credits_reserves.created_at')
            ->get();

        $credits = CreditsReserve::whereBetween('created_at', [$from, $to])->where([['action', '=', 'company']])->orderBy('created_at', 'asc')->get();

        for ($i = 0; $i < $file_services->count(); $i++) {
            $category[$i] = \Carbon\Carbon::parse()->month(explode("-",$file_services[$i]->monthyear)[0])->format('M').'-'.\Carbon\Carbon::parse()->year(explode("-",$file_services[$i]->monthyear)[1])->format('Y');
            $data[$i] = $file_services[$i]->total_files;
        }

        // for ($i = 0; $i < $credits->count(); $i++) {
        //     $category[$i] = $credits[$i]->created_at->format('d M yy');
        //     $data[$i] = round($credits[$i]->credits, 0);
        // }

        return view('customers.adminDashboard', compact('total_customers', 'category', 'data', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $customer = User::where('id', '=', $id)->firstOrFail();
        $customer->activated = 1;
        $customer->save();
        $company = Company::where('id', '=', \checkDomain())->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();
        $mail = MailTemplate::where([['action', '=', 'verifaication_account'], ['company_id', '=', checkDomain()]])->firstOrFail();

        $data = [
            'company_name' => $company->company_name,
            'admin_name' =>  $admin->name,
            'admin_email' =>  $admin->email,
            'name' =>  $customer->name,
            'body' =>  $mail->body,
            'subject' =>  $mail->subject,
            'email' =>  $customer->email,
            'from' => $company->company_email,
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
        ];


        Mail::send('emails.verification', ['data' => $data], function ($m) use ($data) {
            $m->from($data['from'], $data['company_name']);

            $m->to($data['email'], $data['company_name'])->subject($data['subject']);
        });

        $mail_history = new MailHistory([
            'seen' => 0,
            'from' => $company->company_email,
            'user_id' => $customer->id,
            // 'file_service_id' => $file_service->id,
            // 'ticket_id' => checkDomain(),
            'subject' =>  $mail->subject,
            'email_type' => 'verifaication_account',
            // 'sent' => checkDomain(),
            // 'amount' => checkDomain(),
            'company_id' => checkDomain(),
            // 'token' => checkDomain(),
        ]);
        $mail_history->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = User::where('id', '=', $id)->firstOrFail();
        $customer->forceDelete();
    }
    
    public function updateUser($id)
    {
        if(auth()->user()->role == 'admin'){
            $customer = User::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        }else{
            $customer = User::where([['id', '=', auth()->user()->id],['company_id','=',checkDomain()]])->firstOrFail();
        }
        $credit_groups = CreditGroup::where([['company_id','=',checkDomain()]])->get();
        return view('customers.edit', compact('customer','credit_groups'));
    }

    public function updateUserData(Request $request,$id){
        if(auth()->user()->role == 'admin'){
            $customer = User::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        }else{
            $customer = User::where([['id', '=', auth()->user()->id],['company_id','=',checkDomain()]])->firstOrFail();
        }

        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'title' => 'required|max:30',
            'account_type' => 'required|max:30',
            'phone_number' => 'required|max:30',
            'country' => 'required|max:255',
            'address1' => 'required|max:255',
            'address2' => 'required|max:255',
            'province' => 'nullable|max:255',
            'email' => 'required|email|max:255',
            'ticket_display_name' => 'required',
        ]);

        $customer->first_name = $request['first_name'];
        $customer->last_name = $request['last_name'];
        $customer->title = $request['title'];
        $customer->account_type = $request['account_type'];
        $customer->phone = $request['phone_number'];
        $customer->zipcode = $request['zipcode'];
        $customer->city = $request['city'];
        $customer->country = $request['country'];
        $customer->address1 = $request['address1'];
        $customer->address2 = $request['address2'];
        $customer->province = $request['province'];
        $customer->ticket_display_name = $request['ticket_display_name'];
        $customer->email = $request['email'];
        
        if($customer->id == auth()->user()->id){
            if( $request['password']){
                if(!preg_match('/[a-z]/', $request['password'])){
                    $validator->errors()->add('password', 'Must contain at least one lowercase letter.');
                }else
                if(!preg_match('/[A-Z]/', $request['password'])){
                    $validator->errors()->add('password', 'Must contain at least one uppercase  letter.');
                }else
                if(!preg_match('/[0-9]/', $request['password'])){
                    $validator->errors()->add('password', 'Must contain at least one digit.');
                }else
                if(!preg_match('/[?=.*?[#?!@$%^&*-]/', $request['password'])){
                    $validator->errors()->add('password', 'Must contain a special character.');
                }else
                if(strlen($request['password']) < 6){
                    $validator->errors()->add('password', 'The password must be at least 6 characters.');
                }else
                if($request['password'] != $request['password_confirmation']){
                    $validator->errors()->add('password', 'The password confirmation does not match.');
                }else{
                    $customer->password = bcrypt($request['password']);
                }
            }
            
            
            $user_check = User::where([['company_id','=',checkDomain()],['email','=',$customer->email]])->whereNotIn('id',[$customer->id])->get();
            // dd($user_check);
    
            if ($user_check->count()) {
                $validator->errors()->add('email', 'The email has already been taken.');
            }
        }else{
            if(auth()->user()->role == 'admin' && auth()->user()->id != $customer->id){
                $customer->credit_group_id = $request['credit_group_id'];
            }
        }
        
        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
        }

        if ($request->file('profile_image')) {
            $name = $request->file('profile_image')->hashName();
            \Image::make($request->file('profile_image'))->save('img/' . $name);
            $customer->profile_image = $name;
            if(auth()->user()->profile_image() != 'images.png'){
                $userPhoto = 'img/' . auth()->user()->profile_image();
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }
            }
        }

        $customer->save();
        return redirect('edit-user/'.$customer->id)->withSuccess('Successfully updated');
    }
}

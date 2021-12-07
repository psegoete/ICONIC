<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Company\Models\Company;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\CustomerRegistrationMail;
use CreatyDev\Domain\MailTemplate;
use Illuminate\Support\Facades\Mail;
use CreatyDev\Domain\UserTuningCredit;
use GuzzleHttp\Client;
use CreatyDev\Domain\MailHistory;

class TernantLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function index()
    {
        return view('login.index');
    }

    public function register()
    {
        return view('login.register');
    }

    public function tenants(Request $request)
    {
        if (Auth::user()->role == 'super-admin') {

            // if($request->get('search')){
            //     $users =  DB::table('users')->where([['email', 'like', '%'.$request->get('search').'%'],['role','=', 'admin']])->orderBy('updated_at', 'desc')->paginate(10);
            // } else {
            //     $users =  DB::table('users')->where([['role','=', 'admin']])->orderBy('updated_at', 'desc')->paginate(10);
            // }

            if (Auth::user()->role == 'super-admin') {
                if ($request->ajax()) {
                    $data =  DB::table('users')->where([['role', '=', 'admin']])->get();
                    return response()->json(['data' => $data]);
                }
                // config(['APP_NAME' => 'America/Chicago']);

            }
        }

        return view('login.tenants');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'title' => 'required|max:30',
            'account_type' => 'required|max:30',
            'phone_number' => 'required|max:30',
            'country' => 'required|max:255',
            'province' => 'nullable|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed|',
            'terms_and_conditions' => 'required',
            'privacy_policy' => 'required',
        ]);

        if (!preg_match('/[a-z]/', $request['password'])) {
            $validator->errors()->add('password', 'Must contain at least one lowercase letter.');
        }
        if (!preg_match('/[A-Z]/', $request['password'])) {
            $validator->errors()->add('password', 'Must contain at least one uppercase  letter.');
        }
        if (!preg_match('/[0-9]/', $request['password'])) {
            $validator->errors()->add('password', 'Must contain at least one digit.');
        }
        if (!preg_match('/[?=.*?[#?!@$%^&*-]/', $request['password'])) {
            $validator->errors()->add('password', 'Must contain a special character.');
        }

        $user_check = User::where([['email', '=', $request['email']], ['company_id', '=', checkDomain()]])->get();

        if ($user_check->count()) {
            $validator->errors()->add('email', 'The email has already been taken.');
        }

        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
        }

        $user = new User([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'username' => $request['username'],
            'title' => $request['title'],
            'address1' => $request['address1'],
            'address2' => $request['address2'],
            'city' => $request['city'],
            'zipcode' => $request['zipcode'],
            'country' => $request['country'],
            'province' => $request['province'],
            'phone' => $request['phone_number'],
            'account_type' => $request['account_type'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'activated' => 0,
            'company_id' => checkDomain(),
            'role' => 'customer',
        ]);
        $user->save();

        $UserTuningCredit = new UserTuningCredit([
            'credits' => 0,
            'user_id' => $user->id,
            'company_id' => checkDomain(),
        ]);
        $UserTuningCredit->save();

        $company = Company::where('id', '=', \checkDomain())->firstOrFail();
        $customer = User::where([['id', '=', $user->id], ['company_id', '=', checkDomain()]])->firstOrFail();
        $admin = User::where([['role', '=', 'admin'], ['company_id', '=', checkDomain()]])->firstOrFail();

        $mail = MailTemplate::where([['action', '=', 'user_registered'], ['company_id', '=', checkDomain()]])->firstOrFail();
        $admi_mail = MailTemplate::where([['action', '=', 'customer_activation '], ['company_id', '=', checkDomain()]])->firstOrFail();


        $data = [
            'company_name' => $company->company_name,
            'admin_name' =>  $admin->name,
            'admin_email' =>  $admin->email,
            'name' =>  $customer->name,
            'customer_subject' =>  $mail->subject,
            'body' =>  $mail->body,
            'admin_body' =>  $admi_mail->body,
            'admin_subject' =>  $admi_mail->subject,
            'email' =>  $customer->email,
            'from' => $company->company_email,
            'footer' => $company->company_name . ' - ' . $company->city . ' - ' . $company->province . ', ' . $company->country,
        ];

        // Mail::send('emails.customer_registration', ['data' => $data], function ($m) use ($data) {
        //     $m->from($data['from'], $data['company_name']);

        //     $m->to($data['email'], $data['company_name'])->subject($data['customer_subject']);
        // });

        $mail_history = new MailHistory([
            'seen' => 0,
            'from' => $company->company_email,
            'user_id' => $customer->id,
            // 'file_service_id' => $file_service->id,
            // 'comment_id' => $comment->id,
            // 'ticket_id' => $ticket->id,
            'subject' => $mail->subject,
            'email_type' => 'customer_registration',
            // 'sent' => checkDomain(),
            // 'amount' => checkDomain(),
            'company_id' => checkDomain(),
            // 'token' => $passwor_recover->token,
        ]);
        $mail_history->save();

        // Mail::send('emails.customer_activation', ['data' => $data], function ($m) use ($data) {
        //     $m->from($data['from'], $data['company_name']);

        //     $m->to($data['admin_email'], $data['company_name'])->subject($data['admin_subject']);
        // });

        $mail_history = new MailHistory([
            'seen' => 0,
            'from' => $company->company_email,
            'user_id' => $admin->id,
            // 'file_service_id' => $file_service->id,
            // 'comment_id' => $comment->id,
            // 'ticket_id' => $ticket->id,
            'subject' => $admi_mail->subject,
            'email_type' => 'customer_activation',
            // 'sent' => checkDomain(),
            // 'amount' => checkDomain(),
            'company_id' => checkDomain(),
            // 'token' => $passwor_recover->token,
        ]);
        $mail_history->save();

        return redirect('/')
            ->withSuccess('User created successfully.');
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
        //
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
        //
    }
}

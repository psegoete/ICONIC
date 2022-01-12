<?php

namespace CreatyDev\Http;

use Carbon\Carbon;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Company\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Availability;
use CreatyDev\Domain\FileShareCredit;
use CreatyDev\Domain\LegalDocument;
use CreatyDev\Domain\PlatformSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Subscription;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\DeliveryTime;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\CompanyRegistraionMail;
use CreatyDev\Domain\CreditGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use CreatyDev\Domain\MailTemplate;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use CreatyDev\Domain\Invoice;
use CreatyDev\Domain\Order;


use Illuminate\Support\Facades\Mail;


class CompaniesController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super-admin') {

            // $companies =  DB::table('companies')->orderBy('updated_at', 'desc')->get();
            if ($request->ajax()) {
                $data =  DB::table('companies')->where('users.role', '=', 'admin')
                        ->leftJoin('users', 'users.company_id', '=', 'companies.id')
                        ->select(
                            'companies.id',
                            'companies.company_name',
                            'companies.address1',
                            'companies.address2',
                            'companies.zipcode',
                            'companies.city',
                            'companies.domain_name',
                            'companies.country',
                            'companies.company_email',
                            'companies.company_phone',
                            'companies.uuid',
                            'companies.province',
                            'companies.phone_number',
                            'companies.bank_account',
                            'companies.bank_identification_code',
                            'companies.chamber_of_commernce_number',
                            'companies.tax_identifier',
                            'companies.skype_username',
                            'companies.facebook',
                            'companies.twitter',
                            'companies.google',
                            'companies.linkedIn',
                            'companies.youtube',
                            'companies.instagram',
                            'companies.pinterest',
                            'companies.wechat',
                            'companies.qq',
                            'companies.website',
                            'companies.google_tag_manager_code',
                            'companies.google_analytics_code',
                            'companies.company_logo',
                            'companies.active',
                            'companies.blocked',
                            'companies.plan',
                            'companies.updated_at',
                            'companies.created_at',
                            'users.first_name as first_name',
                            'users.last_name as last_name',
                        )
                        ->get();

                return response()->json(['data' => $data]);
            }

            return view('companies.index');
        }
    }

    public function create()
    {

        $packages =  DB::table('packages')->orderBy('updated_at', 'desc')->paginate(10);
        return view('companies.create', compact('packages'));
    }

    public function store(Request $request)
    {


        if ($request->input('option') == 849 || $request->input('option') == 1350 || $request->input('option') == 2399) {
            if ($request->input('option') == 849) {
                $plan = 'basic';
            }
            if ($request->input('option') == 1350) {
                $plan = 'standard';
            }
            if ($request->input('option') == 2399) {
                $plan = 'enterprice';
            }

            $this->validate($request, [
                'company_name' => 'required|unique:companies',
                'address1' => 'required',
                'address2' => 'required',
                'zipcode' => 'required|numeric',
                'city' => 'required',
                'domain_name' => 'required|unique:companies',
                'country' => 'required',
                'company_email' => 'required|email',
                'company_phone' => 'required',
                // 'uuid' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                // 'phone' => 'required',
                'email' => 'required|email',
                'logo' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            $company = new Company([
                'company_name' => $request->input('company_name'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'zipcode' => $request->input('zipcode'),
                'city' => $request->input('city'),
                'company_phone' => $request->input('company_phone'),
                'domain_name' => $request->input('domain_name'),
                'country' => $request->input('country'),
                'company_email' => $request->input('company_email'),
                'plan' => $plan
            ]);

            if ($request->file('logo')) {
                $name = $request->file('logo')->hashName();
                \Image::make($request->file('logo'))->save('logos/' . $name);
                $company->company_logo = $name;
            }

            $company->save();

            $creditGroup = new CreditGroup([
                'default' => 1,
                'name' => 'New Registration Client (default)',
                'company_id' => $company->id,
            ]);
            $creditGroup->save();

            $user = new User([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'activated' => 1,
                'title' => 'Mr.',
                'country' => $request->input('country'),
                'province' => $request->input('city'),
                'company_id' => $company->id,
                'credit_group_id' => $creditGroup->id,
                'role' => 'admin',
                'password' => Hash::make($request->input('password')),
            ]);

            $user->save();

            $Availability = new Availability([
                'company_id' => $company->id,
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
                'holiday' => 'Holiday',
            ]);

            $PlatformSetting = new PlatformSetting([
                'company_id' => $company->id,
            ]);
            
            $LegalDocument = new LegalDocument([
                'company_id' => $company->id,
            ]);
            
            $Availability->save();
            $PlatformSetting->save();
            $LegalDocument->save();
            
            $deliveryTime = new DeliveryTime([
                'company_id' => $company->id,
            ]);
            $deliveryTime->save();

            $subscription = new Subscription([
                'company_id' => $company->id,
                'user_id' => $user->id,
                'subscription_ammount' => $request->input('option'),
                'status' => '0',
                'starts_at' => \Carbon\Carbon::now(),
                'ends_at' => \Carbon\Carbon::now(),
            ]);
            $subscription->save();

            $userCompanyCredits = new UserCompanyCredit([
                'company_id' => $company->id,
                'user_id' => $user->id,
                'credits' => 0,
            ]);

            $userCompanyCredits->save();

            $CreditsReserve = new CreditsReserve([
                'credits' => 1,
                'status' => 0,
                'action' => 'company registration',
                'amount' => $request->input('option'),
                'token' => strtoupper(Str::random(70)),
                'description' => $request->input('company_name') . ' ' . $request->input('option'),
                'company_id' => $company->id,
                'user_id' => $user->id,

            ]);

            $CreditsReserve->save();

            $iconic = User::where([['role', '=', 'super-admin']])->first();

            $file_sharing = new FileShareCredit([
                'credits' => 0,
                'company_id' => $company->id,
                'user_id' => $user->id,

            ]);
            $file_sharing->save();

            $user_registered = new MailTemplate([
                'action' => 'user_registered',
                'name' => 'Welcome (user registered)',
                'subject' => 'Your account on Eagle Eye International',
                'body' => '<p>Thank you for creating an account on&nbsp; '.$company->company_name.' Please be patient as your account is pending verification.</p>',
                'company_id' => $company->id,
            ]);
            $user_registered->save();
            $customer_activation = new MailTemplate([
                'action' => 'customer_activation',
                'name' => 'Customer activation',
                'subject' => 'Customer activation',
                'body' => '<p>You have a client to verify their account.</p>',
                'company_id' => $company->id,
            ]);
            $customer_activation->save();
            $verifaication_account = new MailTemplate([
                'action' => 'verifaication_account',
                'name' => 'Account verified',
                'subject' => 'Successfully activated',
                'body' => '<p>Your account has being activated. You can now start using the system.',
                'company_id' => $company->id,
            ]);
            $verifaication_account->save();

            $basic = '';
            if($plan = 'basic'){
                $basic = "Please point your domain to this IP Address 5.189.174.191";
            }
            

            $data = [
                'subject' => 'Registration request on platform',
                'customer_name' => $company->company_name,
                'company_name' => 'Iconic Code Development',
                'iconic_email' => $iconic->email,
                'email' => $user->email,
                'token' => $CreditsReserve->token,
                'amount' => $request->input('option'),
                'basic' => $basic,
            ];

            // Mail::send('emails.company_registration', ['data' => $data], function ($m) use ($data) {
            //     $m->from($data['iconic_email'], $data['company_name']);

            //     $m->to($data['email'], $data['company_name'])->subject($data['subject']);
            // });

            $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'], ['companyid', '=', 0]])->orderBy('updated_at', 'desc')->get()[0];
            $company->uuid = 'processing';
            
            $return_url = 'return_url=' . url('/') . '/companies/success/' . $CreditsReserve->token;
            $cancel_url = 'cancel_url='.url('/');
            
            $amount = 'amount=' . $CreditsReserve->amount;
            $item_name = 'item_name=' . $CreditsReserve->description;
            $merchant_id = 'merchant_id=' . $payment->merchant_id;
            $merchant_key = 'merchant_key=' . $payment->merchant_key;
            
            $company->save();
            $url = 'https://www.payfast.co.za/eng/process?' . '&' . $merchant_id . '&' . $merchant_key . '&' . $amount . '&' .  $item_name . '&' . $return_url . '&' . $cancel_url;
            return Redirect::away($url);
        } else {
            return back();
        }
    }

    public function blocked($id)
    {
        if (auth::user()->role == 'super-admin') {
            $company = Company::where('id', '=', $id)->firstOrFail();

            if ($company->blocked == 1) {
                $company->blocked = 0;
                $company->save();
                return back()->withSuccess('Successfully unblocked.');
            } else {
                $company->blocked = 1;
                $company->save();
                return back()->withSuccess('Successfully blocked.');
            }
        }
    }

    public function success($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();

        $company = Company::where('id', '=', $CreditsReserve->company_id)->first();

        if ($company->uuid == 'processing') {
            $CreditsReserve->status = 1;
            $company->uuid = 'paid';
            $company->active = 1;

            $company->save();
            $CreditsReserve->save();

            $subscription = Subscription::where('company_id', '=', $CreditsReserve->company_id)->firstOrFail();

            $subscription->starts_at = \Carbon\Carbon::now();
            $subscription->ends_at = \Carbon\Carbon::now()->addMonth();

            $subscription->save();

            $id = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_no', 'length' => 10, 'prefix' => '#']);

            $invoice = new Invoice([
                'description' => 'Platform activation',
                'amount' => $CreditsReserve->amount,
                'invoice_no' => $id,
                'user_id' => $CreditsReserve->user_id,
                'company_id' => $company->id,
            ]);

            $invoice->save();

            $order_id = IdGenerator::generate(['table' => 'orders', 'field' => 'order_reference', 'length' => 10, 'prefix' => '#']);

            $order = new Order([
                'description' => 'Platform activation',
                'amount' => $CreditsReserve->amount,
                'invoice_id' => $invoice->id,
                'status' => 'Completed',
                'order_reference' => $order_id,
                'order_no' => $order_id,
                'user_id' => $CreditsReserve->user_id,
                'company_id' => $company->id,
            ]);

            $order->save();

            $user = User::where('id', '=', $CreditsReserve->user_id)->first();
            $super_admin = User::where('role', '=', 'super-admin')->first();

            $plan = '';
            if ($company->plan == 'standard') {
                $plan = 'Basic';
            }
            if ($company->plan == 'standard') {
                $plan = 'Advanced';
            }
            if ($company->plan == 'enterprice') {
                $plan = 'Ultimate';
            }

            $data = [
                'subject' => 'New request platform order completed',
                'company_name' => $company->company_name,
                'domain' => $company->domain_name,
                'company_email' => $company->company_email,
                'company_phone' => $company->company_phone,
                'plan' => $plan,
                'iconic_email' => $super_admin->email,
                'sales_email' =>'support@aolc.co.za',
                'email' => $user->email,
                'token' => $CreditsReserve->token,
                'credits' => $CreditsReserve->credits,
                'amount' => $CreditsReserve->amount,
            ];
            

            Mail::send('emails.customer_order', ['data' => $data], function ($m) use ($data) {
                $m->from($data['iconic_email'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Payment confirmation on requested platform at Iconic Code Development');
            });

            Mail::send('emails.super_admin_order', ['data' => $data], function ($m) use ($data) {
                $m->from($data['iconic_email'], $data['company_name']);

                $m->to($data['iconic_email'], $data['company_name'])->subject($data['subject']);
            });

            if($CreditsReserve->credits == 3){
                Mail::send('emails.sales', ['data' => $data], function ($m) use ($data) {
                    $m->from($data['iconic_email'], $data['company_name']);
    
                    $m->to($data['sales_email'], $data['company_name'])->subject('Iconic Code Development, customer domain hosting request');
                });
            }
        }
        return redirect('/')
            ->with('success', 'You successfully paid your package. Please see email for more information.

            ');
    }

    public function packagePayment($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();

        $company = Company::where('id', '=', $CreditsReserve->company_id)->firstOrFail();
        $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'], ['companyid', '=', 0]])->orderBy('updated_at', 'desc')->get()[0];

        $company->uuid = 'processing';
        $company->save();

        $return_url = 'return_url=' . url('/') . '/companies/success/' . $CreditsReserve->token;
        $cancel_url = 'cancel_url='.url('/');
        
        $amount = 'amount=' . $CreditsReserve->amount;
        $item_name = 'item_name=' . $CreditsReserve->description;
        $merchant_id = 'merchant_id=' . $payment->merchant_id;
        $merchant_key = 'merchant_key=' . $payment->merchant_key;

        $url = 'https://www.payfast.co.za/eng/process?' . '&' . $merchant_id . '&' . $merchant_key . '&' . $amount . '&' .  $item_name . '&' . $return_url . '&' . $cancel_url;
        return Redirect::away($url);
    }

    public function show($id)
    {
        //
    }

    public function companyInfo()
    {

        if (Availability::where('company_id', '=', checkDomain())->count()) {
            $Availability = Availability::where('company_id', '=', checkDomain())->firstOrFail();
            $PlatformSetting = PlatformSetting::where('company_id', '=', checkDomain())->firstOrFail();
            $LegalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        } else {

            $Availability = new Availability([
                'company_id' => checkDomain(),
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
                'holiday' => 'Holiday',
            ]);

            $PlatformSetting = new PlatformSetting([
                'company_id' => checkDomain(),
            ]);

            $LegalDocument = new LegalDocument([
                'company_id' => checkDomain(),
            ]);

            $Availability->save();
            $PlatformSetting->save();
            $LegalDocument->save();
        }

        $company = Company::where('id', '=', checkDomain())->firstOrFail();

        return view('companies.company_information', compact('Availability', 'PlatformSetting', 'LegalDocument', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::where('id', '=', $id)->firstOrFail();
        $subscription =  DB::table('subscriptions')->where([['company_id','=', $id]])->orderBy('updated_at', 'desc')->get();

        if($subscription->count()){
            if($subscription[0]->ends_at < \Carbon\Carbon::now()){
                $status = 'false';
            }else{
                $status = 'true';
            }
        }
        return view('companies.edit', compact('company','subscription','status'));
    }

    public function legaldocuments(Request $request)
    {
        $LegalDocument = LegalDocument::where('company_id', '=', checkDomain())->firstOrFail();
        $LegalDocument->fill($request->all());
        $LegalDocument->save();

        return back()->withSuccess('Company updated successfully.');
    }

    public function availability(Request $request)
    {
        $Availability = Availability::where('company_id', '=', checkDomain())->firstOrFail();
        if (!$request['monday_status']) {
            $request['monday_status'] = '';
        }
        if (!$request['tuesday_status']) {
            $request['tuesday_status'] = '';
        }
        if (!$request['wednesday_status']) {
            $request['wednesday_status'] = '';
        }
        if (!$request['thursday_status']) {
            $request['thursday_status'] = '';
        }
        if (!$request['friday_status']) {
            $request['friday_status'] = '';
        }
        if (!$request['saturday_status']) {
            $request['saturday_status'] = '';
        }
        if (!$request['sunday_status']) {
            $request['sunday_status'] = '';
        }
        if (!$request['holiday_status']) {
            $request['holiday_status'] = '';
        }

        //  dd($request->all());

        $Availability->fill($request->all());
        $Availability->save();

        return back()->withSuccess('Company updated successfully.');
    }

    public function platformsettings(Request $request)
    {
        $PlatformSetting = PlatformSetting::where('company_id', '=', checkDomain())->firstOrFail();
        $PlatformSetting->fill($request->all());
        $PlatformSetting->save();

        return back()->withSuccess('Company updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        if (Auth::user()->role == 'admin') {

            $user = User::where([['id', '=', Auth::user()->id]])->firstOrFail();
            $company = Company::where([['id', '=', $id]])->firstOrFail();
            if ($user->company_id == $company->id) {
                $this->validate($request, [
                    'company_name' => 'required',
                    'address1' => 'required',
                    'address2' => 'required',
                    'zipcode' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'company_email' => 'required',
                    // 'company_phone' => 'required',
                ]);

                $company->fill($request->all());

                if ($request->file('company_logo')) {
                    $name = $request->file('company_logo')->hashName();
                    \Image::make($request->file('company_logo'))->save('logos/' . $name);
                    $company->company_logo = $name;

                    $logo = 'logos/' . Company::where('id', '=', checkDomain())->firstOrFail()->company_logo;
                    if (file_exists($logo)) {
                        @unlink($logo);
                    }
                }

                $company->save();
                return back()->with('success', 'Company updated successfully.');
            } else {
                return back();
            }
        } else if (Auth::user()->role == 'super-admin') {

            $company = Company::where('id', '=', $id)->firstOrFail();

            $this->validate($request, [
                'domain_name' => 'required',
                // 'active' => 'required',
                'plan' => 'required',
            ]);

            if ($request->input('plan') == 849) {
                $plan = 'basic';
            }
            if ($request->input('plan') == 1350) {
                $plan = 'standard';
            }
            if ($request->input('plan') == 2399) {
                $plan = 'enterprice';
            }

            $company->domain_name = $request->input('domain_name');
            if($request->input('active') ){
                $company->active = $request->input('active');
            }
            $company->plan = $plan;

            $company->save();
            $subscription = Subscription::where('company_id', '=', $company->id)->firstOrFail();

            $subscription->subscription_ammount = $request->input('plan');
            if($request->input('subscribe') || $request->input('active') == 1){
            $subscription->starts_at = \Carbon\Carbon::now();
            $subscription->ends_at = \Carbon\Carbon::now()->addMonth();
            }

            $subscription->save();


            return back()->withSuccess('Company updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function deliveryTime()
    {
        if (DeliveryTime::where('company_id', '=', checkDomain())->count()) {
            $deliveryTime = DeliveryTime::where('company_id', '=', checkDomain())->firstOrFail();
        } else {
            $deliveryTime = new DeliveryTime([
                'minimum_time' => '',
                'maximum_time' => '',
                'company_id' => checkDomain()
            ]);
            $deliveryTime->save();
        }
        return view('companies.delivery_time', compact('deliveryTime'));
    }

    public function updateDeliveryTime(Request $request)
    {

        // $this->validate($request, [
        //     'minimum_time' => 'required',
        //     'maximum_time' => 'required',
        // ]);

        $deliveryTime = DeliveryTime::where('company_id', '=', checkDomain())->firstOrFail();
        $deliveryTime->minimum_time = $request->input('minimum_time');
        $deliveryTime->maximum_time = $request->input('maximum_time');
        $deliveryTime->save();

        return back()->with('success', 'Delivery time updated successfully.');
    }
    public function destroy($id)
    {
        $company = Company::where('id', '=', $id)->firstOrFail();
        $company->delete();

        // return back()->withSuccess("{$company->company_name} company deleted successfully.");
    }

    public function mail()
    {
        if (Auth::user()->role == 'admin') {
            $mails =  MailTemplate::where([['company_id', '=', checkDomain()]])->get();
            return view('email_templates.mails', compact('mails'));
        }
    }
    public function mailEdit($id)
    {
        if (Auth::user()->role == 'admin') {
            $mail =  MailTemplate::where([['id', '=', $id]])->firstOrFail();
            return view('email_templates.edit', compact('mail'));
        }
    }

    public function updateMail($id, Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $mail =  MailTemplate::where([['id', '=', $id]])->firstOrFail();

            $mail->name = $request->input('name');
            $mail->subject = $request->input('subject');
            $mail->body = $request->input('body');
            $mail->save();

            return back();
        }
    }

    public function videoPlayer()
    {
        return view('companies.video');
    }
}

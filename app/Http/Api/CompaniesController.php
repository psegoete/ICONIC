<?php

namespace CreatyDev\Http\api;

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

            if ($request->ajax()) {
                $data =  DB::table('companies')->orderBy('updated_at', 'desc')->get();
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
                // 'company_phone' => 'required',
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

            $subscription = new Subscription([
                'company_id' => $company->id,
                'user_id' => $user->id,
                'subscription_ammount' => $request->input('option'),
                'status' => '0',
                'starts_at' => \Carbon\Carbon::now(),
                'ends_at' => \Carbon\Carbon::now(),
            ]);
            $subscription->save();

            $deliveryTime = new DeliveryTime([
                'minimum_time' => '',
                'maximum_time' => '',
                'company_id' => checkDomain()
            ]);
            $deliveryTime->save();

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

            $data = [
                'subject' => 'Request platform',
                'company_name' => 'Iconic Code Development',
                'iconic_email' => $iconic->email,
                'email' => $user->email,
                'token' => $CreditsReserve->token,
                'amount' => $request->input('option'),
            ];

            // Mail::to($user->email)->send(new CompanyRegistraionMail($data));

            Mail::send('emails.company_registration', ['data' => $data], function ($m) use ($data) {
                $m->from($data['iconic_email'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject($data['subject']);
            });

            return redirect('/')->with('success', 'Company created successfully. Please check your email to make payment.');
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

            $data = [
                'subject' => 'Request platform order completed',
                'company_name' => $company->company_name,
                'iconic_email' => $super_admin->email,
                'email' => $user->email,
                'token' => $CreditsReserve->token,
                'amount' => $CreditsReserve->amount,
            ];

            Mail::send('emails.customer_order', ['data' => $data], function ($m) use ($data) {
                $m->from($data['iconic_email'], $data['company_name']);

                $m->to($data['email'], $data['company_name'])->subject('Successfully requested platform');
            });

            Mail::send('emails.super_admin_order', ['data' => $data], function ($m) use ($data) {
                $m->from($data['iconic_email'], $data['company_name']);

                $m->to($data['iconic_email'], $data['company_name'])->subject($data['subject']);
            });
        }
        return redirect('/')
            ->with('success', 'You successfully paid your package.');
    }

    public function packagePayment($token)
    {
        // dd(url('/'));
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();

        $company = Company::where('id', '=', $CreditsReserve->company_id)->firstOrFail();
        $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'], ['companyid', '=', 0]])->orderBy('updated_at', 'desc')->get()[0];

        $company->uuid = 'processing';
        $company->save();

        $return_url = 'return_url=https://register.iconiccodedevelopment.com/companies/success/' . $CreditsReserve->token;
        $cancel_url = 'cancel_url=https://register.iconiccodedevelopment.com/';
        $amount = 'amount=' . $CreditsReserve->amount;
        $item_name = 'item_name=' . $CreditsReserve->description;
        $merchant_id = 'merchant_id=' . $payment->merchant_id;
        $merchant_key = 'merchant_key=' . $payment->merchant_key;

        $url = 'https://www.payfast.co.za​​/eng/process?' . '&' . $merchant_id . '&' . $merchant_key . '&' . $amount . '&' .  $item_name . '&' . $return_url;
        return Redirect::away($url);
    }

    public function show($id)
    {
        //
    }

    public function companyInfo(Request $request)
    {
        $company = Company::where('id', '=', $request->input('company_id'))->firstOrFail();

        if (Availability::where('company_id', '=', $request->input('company_id'))->count()) {
            $Availability = Availability::where('company_id', '=', 1)->firstOrFail();
            $PlatformSetting = PlatformSetting::where('company_id', '=', 1)->firstOrFail();
            $LegalDocument = LegalDocument::where('company_id', '=', 1)->firstOrFail();
        } else {

            $Availability = new Availability([
                'company_id' => $request->input('company_id'),
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
                'company_id' => $request->input('company_id'),
            ]);

            $LegalDocument = new LegalDocument([
                'company_id' => $request->input('company_id'),
            ]);

            $Availability->save();
            $PlatformSetting->save();
            $LegalDocument->save();
        }

        // $company = Company::where('id', '=', 1)->firstOrFail();

        return response()->json(['availability' => $Availability,'platformSetting' => $PlatformSetting,'legalDocument' => $LegalDocument,'company' => $company], 200);
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
        return view('companies.edit', compact('company'));
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
                'active' => 'required',
            ]);

            $company->domain_name = $request->input('domain_name');
            $company->active = $request->input('active');

            $company->save();
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

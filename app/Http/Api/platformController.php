<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Availability;
use CreatyDev\Domain\LegalDocument;
use CreatyDev\Domain\PlatformSetting;
use CreatyDev\Domain\Subscription;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\CompanyRegistraionMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use CreatyDev\Domain\Company\Models\Company;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class platformController extends Controller
{
    //

    public function store(Request $request){
        $this->validate($request, [
            'company_name' => 'required|unique:companies',
            'address1' => 'required',
            'address2' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'domain_name' => 'required|unique:companies',
            'country' => 'required',
            'company_email' => 'required',
            // 'company_phone' => 'required',
            // 'uuid' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
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
            // 'company_phone' => $request->input('company_phone')
        ]);

        if($request->file('files')){
            $name = $request->file('files')->hashName();
            \Image::make($request->file('files'))->save('logos/'.$name);
            $company->company_logo = $name;

        }

        $company->save();

        // dd($company);

        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'activated' => 1,
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
            'amount' => 8000,
            'token' => strtoupper(Str::random(70)),
            'description' => 'Company credits',
            'company_id' => $company->id,
            'user_id' => $user->id, 
            
            ]);

        $CreditsReserve->save();

        $iconic = User::where([['role', '=', 'super-admin']])->first();

        $data = [
            'subject' => $company->company_name. ' Registration request',
            'iconic_email' => $iconic->email,
            'token' => $CreditsReserve->token,
        ];

        Mail::to($user->email)->send(new CompanyRegistraionMail($data));
        return redirect('/')
            ->withSuccess('Company created successfully.');
    }
}

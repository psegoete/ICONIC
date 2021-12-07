<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\FileShareCredit;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\Company\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use CreatyDev\Domain\Paymentgetaway;
use Illuminate\Support\Facades\DB;



class FilesSharingCreditsController extends Controller
{

    public function index(Request $request)
    {
        $file_sharing = FileShareCredit::where('id', '=', auth::user()->id)->first();

        if ($file_sharing) {
        } else {
            $file_sharing = new FileShareCredit([
                'credits' => 0,
                'company_id' => \checkDomain(),
                'user_id' => auth::user()->id,

            ]);
            $file_sharing->save();
        }
        return view('file_sharing.index', compact('file_sharing'));
    }

    public function success($token)
    {

        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $file_sharing = FileShareCredit::where([['company_id', '=', checkDomain()]])->firstOrFail();
        if ($CreditsReserve->status == '0') {

            $file_sharing->credits = $file_sharing->credits + $CreditsReserve->credits;
            $CreditsReserve->status = 1;
            $file_sharing->save();
            $CreditsReserve->save();
        }

        return redirect('/')
            ->withSuccess('You successfully bought sharing credits.');
    }


    public function store(Request $request)
    {



        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $CreditsReserve = new CreditsReserve([
            'credits' => $request->input('credits'),
            'status' => 0,
            'action' => 'sharing',
            'amount' => $request->input('credits') * 15,
            'token' => strtoupper(Str::random(70)),
            'description' => $request->input('credits') . ' sharing credits credits',
            'company_id' => \checkDomain(),
            'user_id' => auth::user()->id,

        ]);

        $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'], ['companyid', '=', 0]])->orderBy('updated_at', 'desc')->get()[0];
        $CreditsReserve->save();
        $return_url = 'return_url=' . 'http://' . $company->domain_name . '/file-sharing/success/' . $CreditsReserve->token;
        $cancel_url = 'cancel_url=' . 'http://' . $company->domain_name . '/file-sharing/cancel/' . $CreditsReserve->token;
        $notify_url = '';
        $amount = 'amount=' . $CreditsReserve->amount;
        $item_name = 'item_name=' . $CreditsReserve->description;
        $merchant_id = 'merchant_id=' . $payment->merchant_id;
        $merchant_key = 'merchant_key=' . $payment->merchant_key;

        $url = 'https://www.payfast.co.za/eng/process?' . '&' . $merchant_id . '&' . $merchant_key . '&' . $amount . '&' .  $item_name . '&' . $return_url . '&' . $cancel_url;
        return Redirect::away($url);
    }

    public function cancel($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $CreditsReserve->delete();
        return redirect('/');
    }
}

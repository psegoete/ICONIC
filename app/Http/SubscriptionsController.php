<?php

namespace CreatyDev\Http;

use Carbon\Carbon;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\PaymentGetaway;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Subscription;
use CreatyDev\Domain\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class SubscriptionsController extends Controller
{
    public function index(){
        $subscription =  DB::table('subscriptions')->where([['company_id','=', checkDomain()]])->orderBy('updated_at', 'desc')->get();
        // dd(\Carbon\Carbon::parse($subscription[0]->ends_at)->addDays(1)->format('d M yy') );
        if($subscription->count()){
            if($subscription[0]->ends_at < \Carbon\Carbon::now()){
                $status = 'false';
            }else{
                $status = 'true';
            }
        }

        return view('subscriptions.index',compact('subscription','status'));
    }

    public function store(Request $request)
    {
        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $subscription = Subscription::where('company_id', '=', checkDomain())->firstOrFail();
        $payment_getaway = PaymentGetaway::where([['payment_provider','=','payfast'],['companyid','=',0]])->first();

        if($payment_getaway){

            $CreditsReserve = new CreditsReserve([
                'credits' => 1,
                'status' => 0,
                'action' => 'subscription',
                'amount' => $subscription->subscription_ammount,
                'token' => strtoupper(Str::random(70)),
                'description' => 'Subscription',
                'company_id' => \checkDomain(),
                'user_id' => auth::user()->id, 
                ]);
                
            $CreditsReserve->save();
            $return_url = 'return_url='.'http://'.$company->domain_name.'/subscriptions/'.$CreditsReserve->token;
            $cancel_url = 'cancel_url='.'http://'.$company->domain_name.'/subscriptions/cancel/'.$CreditsReserve->token;
            $notify_url = '';
            $amount = 'amount=' . $CreditsReserve->amount;
            $item_name = 'item_name=' . $CreditsReserve->description;
            $merchant_id = 'merchant_id=' . $payment_getaway->merchant_id;
            $merchant_key = 'merchant_key=' . $payment_getaway->merchant_key;
    
            $url = 'https://www.payfast.co.za/eng/process?' . '&'. $merchant_id .'&'. $merchant_key .'&'. $amount.'&'.  $item_name .'&'. $return_url . '&' . $cancel_url;
            return Redirect::away($url); 
        }else{
            return back()->with('error', 'Payment getaway does not exist. Please contact Iconic development');
        }
    }

    public function show($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();

        $subscription = Subscription::where('company_id', '=', checkDomain())->firstOrFail();

        $subscription->starts_at = \Carbon\Carbon::now();
        $subscription->ends_at = \Carbon\Carbon::now()->addMonth();

        $subscription->save();

        $id = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_no','length' => 10, 'prefix' =>'#']);

        $invoice = new Invoice([
            'description' => 'Credit purchase ('. \round($CreditsReserve->credits,0) .' credits)',
            'amount' => $CreditsReserve->amount,
            'invoice_no' => $id,
            'user_id' => auth::user()->id,
            'company_id' => \checkDomain(),
        ]);

    $invoice->save();
        return redirect('/');



        // if($CreditsReserve->status == '0'){

        //     $CreditsReserve = Subscription::where('company_id', '=', checkDomain())->first();

        //     if($UserTuningCredit->count()){
        //         $UserTuningCredit[0]->credits = $UserTuningCredit[0]->credits + $CreditsReserve->credits;
        //         $UserTuningCredit[0]->save();
        //     }else{
        //         $usertuningCredit = new UserTuningCredit([
        //             'credits' => $CreditsReserve->credits,
        //             'company_id' => \checkDomain(),
        //             'user_id' => $CreditsReserve->user_id,
        //         ]);
        //         $usertuningCredit->save();
        //     }
        //     $CreditsReserve->status = 1;
        //     $CreditsReserve->save();
    
        //     $id = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_no','length' => 10, 'prefix' =>'#']);
    
        //     $invoice = new Invoice([
        //         'description' => 'Credit purchase ('. \round($CreditsReserve->credits,0) .' credits)',
        //         'amount' => $CreditsReserve->amount,
        //         'invoice_no' => $id,
        //         'user_id' => auth::user()->id,
        //         'company_id' => \checkDomain(),
        //     ]);
    
        //     $invoice->save();
    
        //     $order_id = IdGenerator::generate(['table' => 'orders', 'field' => 'order_reference','length' => 10, 'prefix' =>'#']);
    
        //     $order = new Order([
        //         'description' => \round($CreditsReserve->credits,0) .' tuning credits',
        //         'amount' => $CreditsReserve->amount,
        //         'invoice_id' => $invoice->id,
        //         'status' => 'Completed',
        //         'order_reference' => $order_id,
        //         'order_no' => $order_id,
        //         'user_id' => auth::user()->id,
        //         'company_id' => \checkDomain(),
        //     ]);
    
        //     $order->save();
        // }

        // $tuning_credits =  DB::table('tuning_credits')->where([['company_id','=', checkDomain()]])->orderBy('updated_at', 'desc')->get();
        // return redirect('buy-credits')->with('company_credits', [$tuning_credits])
        // ->withSuccess('You successfully bought credits.');
    }


    public function cancel($token){
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $CreditsReserve->delete();
        return redirect('subscriptions');
    }
}

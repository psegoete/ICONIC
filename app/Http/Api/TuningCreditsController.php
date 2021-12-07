<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\TuningCredit;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\UserCompanyCredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Invoice;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\Order;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Paymentgetaway;
use Yajra\Datatables\Datatables;
use CreatyDev\Domain\Transaction;



class TuningCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tuning_credits =  DB::table('tuning_credits')->where([['company_id', '=', auth('api')->user()->company_id]])->get();

        return response()->json(['success' => 'Successfully',
        'errors' => '','tuning_credits'=>$tuning_credits], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tuning_credits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|numeric|min:1',
            'from' => 'required|numeric|min:1',
            'for' => 'required|numeric|min:1',
        ], [
            'description.required' => 'The credits field is required',
            'description.min' => 'The credits must be at least 1',
            'description.numeric' => 'The credits must be a number',
        ]);

        $tunningcredit = new TuningCredit([
            'description' => $request->input('description'),
            'from' => $request->input('from'),
            'for' => $request->input('for'),
            'company_id' => auth('api')->user()->company_id,
        ]);

        $tunningcredit->save();

        return response()->json(['success' => 'Tunningcredit created successfully.',
        'errors' => ''], 201);
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

    public function buyCredits(Request $request)
    {
        $tuning_credits =  DB::table('tuning_credits')->where([['company_id', '=', auth('api')->user()->company_id]])->orderBy('description', 'asc')->get();

        return response()->json(['success' => 'Successfully.',
        'errors' => '','tuning_credits'=> $tuning_credits], 200);
    }

    public function success($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();


        $UserTuningCredit = UserTuningCredit::where('user_id', '=', $CreditsReserve->user_id)->get();
        $UserCompanyCredit = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->get();

        if ($CreditsReserve->status == '0') {

            if ($UserTuningCredit->count()) {
                $UserCompanyCredit[0]->credits = $UserCompanyCredit[0]->credits - $CreditsReserve->credits;
                $UserCompanyCredit[0]->save();
                $UserTuningCredit[0]->credits = $UserTuningCredit[0]->credits + $CreditsReserve->credits;
                $UserTuningCredit[0]->save();
            } else {
                $usertuningCredit = new UserTuningCredit([
                    'credits' => $CreditsReserve->credits,
                    'company_id' => auth('api')->user()->company_id,
                    'user_id' => $CreditsReserve->user_id,
                ]);
                $usertuningCredit->save();
            }
            $CreditsReserve->status = 1;
            $CreditsReserve->save();

            $id = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_no', 'length' => 10, 'prefix' => '#']);

            $invoice = new Invoice([
                'description' => 'Credit purchase (' . \round($CreditsReserve->credits, 0) . ' credits)',
                'amount' => $CreditsReserve->amount,
                'invoice_no' => $id,
                'user_id' => auth('api')->user()->id,
                'company_id' => auth('api')->user()->company_id,
            ]);

            $invoice->save();

            $order_id = IdGenerator::generate(['table' => 'orders', 'field' => 'order_reference', 'length' => 10, 'prefix' => '#']);

            $order = new Order([
                'description' => \round($CreditsReserve->credits, 0) . ' tuning credits',
                'amount' => $CreditsReserve->amount,
                'invoice_id' => $invoice->id,
                'status' => 'Completed',
                'order_reference' => $order_id,
                'order_no' => $order_id,
                'user_id' => auth('api')->user()->id,
                'company_id' => auth('api')->user()->company_id,
            ]);

            $order->save();

            $transaction = new Transaction([
                'credits' => $CreditsReserve->credits,
                'description' => 'Tuning credits purchase',
                'status' => 'Completed',
                'user_id' => $CreditsReserve->user_id,
                'company_id' => auth('api')->user()->company_id,
            ]);
            $transaction->save();
        }

        $tuning_credits =  DB::table('tuning_credits')->where([['company_id', '=', auth('api')->user()->company_id]])->orderBy('updated_at', 'desc')->get();
        return redirect('buy-credits')->with('company_credits', [$tuning_credits])
            ->withSuccess('You successfully bought credits.');
    }

    public function cancel($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $CreditsReserve->delete();
        // return redirect('/');

        return redirect()->back()->with('error', 'Successfully cancelled payment for buying tuning credits');
    }

    public function payCredits(Request $request)
    {

        $companyCredit = UserCompanyCredit::where([['company_id', '=', auth('api')->user()->company_id]])->first();
        $tunningcredit = TuningCredit::where([['id', '=', $request->input('id')], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        if ($tunningcredit->description < $companyCredit->credits ) {
            // return response()->json(['url' => $tunningcredit], 200);

            $company = Company::where('id', '=', auth('api')->user()->company_id)->firstOrFail();
            $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'], ['company_id', '=', auth('api')->user()->company_id], ['companyid', '=', '1']])->orderBy('updated_at', 'desc')->get()[0];

            $CreditsReserve = new CreditsReserve([
                'credits' => $tunningcredit->description,
                'status' => 0,
                'action' => 'tuning',
                'amount' => $tunningcredit->for,
                'token' => (Str::random(70)),
                'description' => 'Tuning credits',
                'company_id' => auth('api')->user()->company_id,
                'user_id' => auth('api')->user()->id,
            ]);

            $CreditsReserve->save();
            $return_url = 'return_url=' . 'https://' . $company->domain_name . '/success/' . $CreditsReserve->token;
            $cancel_url = 'cancel_url=' . 'https://' . $company->domain_name . '/tuning-credits/cancel/' . $CreditsReserve->token;
            $notify_url = '';
            $amount = 'amount=' . $CreditsReserve->amount;
            $item_name = 'item_name=' . $CreditsReserve->description;
            $merchant_id = 'merchant_id=' . $payment->merchant_id;
            $merchant_key = 'merchant_key=' . $payment->merchant_key;

            $url = 'https://www.payfast.co.za/eng/process?' . '&' . $merchant_id . '&' . $merchant_key . '&' . $amount . '&' .  $item_name . '&' . $return_url . '&' . $cancel_url;
            // return Redirect::away($url);
            return response()->json(['url' => $url], 200);
        } else {
            return response()->json(['error' => 'The company does not have sufficient credits.'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tunningcredit = TuningCredit::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        return response()->json(['success' => 'Successfully.',
        'errors' => '','tunningcredit'=> $tunningcredit], 200);
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
        $tunningcredit = TuningCredit::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $this->validate($request, [
            'description' => 'required|numeric|min:1',
            'from' => 'required|numeric|min:1',
            'for' => 'required|numeric|min:1',
        ]);

        $tunningcredit->fill($request->all());
        $tunningcredit->save();

        return response()->json(['success' => 'Tunning credits updated successfully..',
        'errors' => ''], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tunningcredit = TuningCredit::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tunningcredit->delete();

        return response()->json(['success' => 'Tunning credits deleted successfully.',
        'errors' => ''], 201);
    }
}

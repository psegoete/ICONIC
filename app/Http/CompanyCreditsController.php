<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\CompanyCredit;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Invoice;
use CreatyDev\Domain\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\App;
use CreatyDev\Domain\CreditsReserve;
use CreatyDev\Domain\Company\Models\Company;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use CreatyDev\Domain\Paymentgetaway;
use Yajra\Datatables\Datatables;


class CompanyCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $data =  DB::table('company_credits')->orderByRaw('description asc')->get();
                return response()->json(['data' => $data]);
            }
        }
            
        return view('company_credits.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company_credits.create');
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
            'description' => 'required|integer|min:1',
            'from' => 'required|numeric|min:1',
            'for' => 'required|numeric|min:1',
            
        ],[
            'description.required' => 'The credits field is required',
            'description.min' => 'The credits must be at least 1',
            'description.integer' => 'The credits must be a number',
        ]);



        $companyCredit = new CompanyCredit([
            'description' => $request->input('description'),
            'from' => $request->input('from'),
            'for' => $request->input('for'),
           
        ]);

        $companyCredit->save();

        return redirect()->route('company-credits.index')
            ->withSuccess('Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyCredit = CompanyCredit::where('id', '=', $id)->firstOrFail();
       return view('company_credits.edit', compact('companyCredit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyCredit = CompanyCredit::where('id', '=', $id)->firstOrFail();
       return view('company_credits.edit', compact('companyCredit'));
    }

    public function success($token)
    {
        
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $UserCompanyCredit = UserCompanyCredit::where('user_id', '=', $CreditsReserve->user_id)->get();

        if($CreditsReserve->status == '0'){

            if($UserCompanyCredit->count()){
                $UserCompanyCredit[0]->credits = $UserCompanyCredit[0]->credits + $CreditsReserve->credits;
                $UserCompanyCredit[0]->save();
            }else{
                $userCompanyCredit = new UserCompanyCredit([
                    'credits' => $CreditsReserve->credits,
                    'company_id' => \checkDomain(),
                    'user_id' => $CreditsReserve->user_id,
                ]);
                $userCompanyCredit->save();
            }
            $CreditsReserve->status = 1;
            $CreditsReserve->save();
    
            $id = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_no','length' => 10, 'prefix' =>'#']);
    
            $invoice = new Invoice([
                'description' => 'Credit purchase ('. \round($CreditsReserve->credits,0) .' credits)',
                'amount' => $CreditsReserve->amount,
                'invoice_no' => $id,
                'user_id' => auth::user()->id,
                'company_id' => \checkDomain(),
            ]);
    
            $invoice->save();
    
            $order_id = IdGenerator::generate(['table' => 'orders', 'field' => 'order_reference','length' => 10, 'prefix' =>'#']);
    
            $order = new Order([
                'description' => \round($CreditsReserve->credits,0) .' tuning credits',
                'amount' => $CreditsReserve->amount,
                'invoice_id' => $invoice->id,
                'status' => 'Completed',
                'order_reference' => $order_id,
                'order_no' => $order_id,
                'user_id' => auth::user()->id,
                'company_id' => \checkDomain(),
            ]);
    
            $order->save();
        }

        $company_credits =  DB::table('company_credits')->orderBy('description', 'asc')->get();
        return redirect('credits')->with('company_credits', [$company_credits])
            ->withSuccess('You successfully bought credits.');
        
    }

    public function Credits()
    {
        $company_credits =  DB::table('company_credits')->orderBy('description', 'asc')->get();
        return view('company_credits.credit', compact('company_credits'));
    }

    public function companyCredits(Request $request)
    {
        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $companyCredit = CompanyCredit::where('id', '=', $request->input('id'))->firstOrFail();
        // $payment = Paymentgetaway::where([['payment_provider', '=', 'payfast'],['companyid','=',0]])->firstOrFail();
        $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'],['companyid','=',0]])->orderBy('updated_at', 'desc')->get()[0];
                
        $CreditsReserve = new CreditsReserve([
            'credits' => $companyCredit->description,
            'status' => 0,
            'action' => 'company',
            'amount' => $companyCredit->for,
            'token' => strtoupper(Str::random(70)),
            'description' => 'Company credits',
            'company_id' => \checkDomain(),
            'user_id' => auth::user()->id, 
            
            ]);
            
            $CreditsReserve->save();
            $return_url = 'return_url='.'http://'.$company->domain_name.'/company-credits/success/'.$CreditsReserve->token;
            $cancel_url = 'cancel_url='.'http://'.$company->domain_name.'/company-credits/cancel/'.$CreditsReserve->token;
            $notify_url = '';
            $amount = 'amount=' . $CreditsReserve->amount;
            $item_name = 'item_name=' . $CreditsReserve->description;
            $merchant_id = 'merchant_id=' . $payment->merchant_id;
            $merchant_key = 'merchant_key=' . $payment->merchant_key;

            $url = 'https://www.payfast.co.za/eng/process?' . '&'. $merchant_id .'&'. $merchant_key .'&'. $amount.'&'.  $item_name .'&'. $return_url .'&'. $cancel_url;
            return Redirect::away($url);
    }

    public function cancel($token){
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $CreditsReserve->delete();
        return redirect('/');
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
        $companyCredit = CompanyCredit::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'description' => 'required|numeric|min:1',
            'from' => 'required|numeric|min:1',
            'for' => 'required|numeric|min:1',
            
        ],[
            'description.required' => 'The credits field is required',
            'description.integer' => 'The credits must be a number',
        ]);
        
        $companyCredit->fill($request->all());
        //$gearboxe->fill($request->only('filename'));
        $companyCredit->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('company-credits.index')
            ->withSuccess('Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyCredit = CompanyCredit::where('id', '=', $id)->firstOrFail();
        $companyCredit->delete();

        // return back()->withSuccess("{$companyCredit->credits} company deleted successfully.");
    }
}

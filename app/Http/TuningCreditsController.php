<?php

namespace CreatyDev\Http;

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
use CreatyDev\Domain\CreditGroup;
use CreatyDev\Domain\CredittierAmount;
use CreatyDev\Domain\Credittier;
use Illuminate\Support\Facades\Validator;

class TuningCreditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if(!Auth::user()){
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
        // if ($request->ajax()) {
        //     $data =  DB::table('tuning_credits')->where([['company_id','=',checkDomain()]])->get();
        //     return response()->json(['data' => $data]);
            
        // }
        $credit_groups = CreditGroup::where([['company_id','=',checkDomain()]])->get();
        $credit_tier_amounts = CredittierAmount::where([['company_id','=',checkDomain()]])->get();
        // dd($credit_groups);
        
        return view('tuning_credits.index', compact('credit_groups','credit_tier_amounts'));

    }

    protected function getActionColumn($data): string
    {
        $editUrl = route('tuning-credits.edit',$data->id);
        $csrf_token = csrf_token();
        return "<a href='$editUrl' class='btn btn-success' data-id='$data->id'>Edit </a>
                <meta name='csrf-token' content='$csrf_token'>
                <a id='delete-user' data-id='$data->id' class='btn btn-danger delete-user'>Delete</a>";
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
        ],[
            'description.required' => 'The credits field is required',
            'description.min' => 'The credits must be at least 1',
            'description.numeric' => 'The credits must be a number',
        ]);

        $tunningcredit = new TuningCredit([
            'description' => $request->input('description'),
            'from' => $request->input('from'),
            'for' => $request->input('for'),
            'company_id' => checkDomain(),
        ]);

        $tunningcredit->save();

        return redirect()->route('tuning-credits.index')
            ->withSuccess('Tunningcredit created successfully.'); 
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

        $credits_amounts = CredittierAmount::where([['company_id','=', checkDomain()]])->get();
        
        $tuning_credits =  DB::table('tuning_credits')->where([['company_id','=', checkDomain()]])->orderBy('description', 'asc')->get();
        return view('tuning_credits.buy_credit', compact('tuning_credits','credits_amounts'));
    }

    public function success($token)
    {
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();


        $UserTuningCredit = UserTuningCredit::where('user_id', '=', $CreditsReserve->user_id)->get();
        $UserCompanyCredit = UserCompanyCredit::where([['company_id','=', checkDomain()]])->get();

        if($CreditsReserve->status == '0'){

            if($UserTuningCredit->count()){
                $UserCompanyCredit[0]->credits = $UserCompanyCredit[0]->credits - $CreditsReserve->credits;
                $UserCompanyCredit[0]->save();
                $UserTuningCredit[0]->credits = $UserTuningCredit[0]->credits + $CreditsReserve->credits;
                $UserTuningCredit[0]->save();
            }else{
                $usertuningCredit = new UserTuningCredit([
                    'credits' => $CreditsReserve->credits,
                    'company_id' => \checkDomain(),
                    'user_id' => $CreditsReserve->user_id,
                ]);
                $usertuningCredit->save();
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

            $transaction = new Transaction([
                'credits' => $CreditsReserve->credits,
                'description' => 'Tuning credits purchase',
                'status' => 'Completed',
                'user_id' => $CreditsReserve->user_id,
                'company_id' => checkDomain(),
            ]);
            $transaction->save();
        }

        $tuning_credits =  DB::table('tuning_credits')->where([['company_id','=', checkDomain()]])->orderBy('updated_at', 'desc')->get();
        return redirect('buy-credits')->with('company_credits', [$tuning_credits])
        ->withSuccess('You successfully bought credits.');
    }

    public function cancel($token){
        $CreditsReserve = CreditsReserve::where('token', '=', $token)->firstOrFail();
        $CreditsReserve->delete();
        return redirect('/');
    }

    public function payCredits(Request $request)
    {

        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $companyCredit = UserCompanyCredit::where([['company_id','=',checkDomain()]])->first();
        $tunningcredit = Credittier::where([['id', '=', $request->input('id')],['company_id','=',checkDomain()]])->firstOrFail();
        // dd($tunningcredit);
        if(($tunningcredit->description < $companyCredit->credits && $company->plan != 'enterprice') || $company->plan == 'enterprice'){

            $company = Company::where('id', '=', checkDomain())->firstOrFail();
            $payment =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'],['company_id','=',checkDomain()]])->orderBy('updated_at', 'desc')->get()[0];
    
            
            $CreditsReserve = new CreditsReserve([
                'credits' => CredittierAmount::where([['id', '=', $tunningcredit->credittier_amounts_id],['company_id','=',checkDomain()]])->firstOrFail()->amount,
                'status' => 0,
                'action' => 'tuning',
                'amount' => $tunningcredit->for,
                'token' =>  (Str::random(70)),
                'description' => 'Tuning credits',
                'company_id' => \checkDomain(),
                'user_id' => auth::user()->id,
                ]);
                
                $CreditsReserve->save();
                $return_url = 'return_url='.'http://'.$company->domain_name.'/success/'.$CreditsReserve->token;
                $cancel_url = 'cancel_url='.'http://'.$company->domain_name.'/tuning-credits/cancel/'.$CreditsReserve->token;
                $notify_url = '';
                $amount = 'amount=' . $CreditsReserve->amount;
                $item_name = 'item_name=' . $CreditsReserve->description;
                $merchant_id = 'merchant_id=' . $payment->merchant_id;
                $merchant_key = 'merchant_key=' . $payment->merchant_key;
    
                $url = 'https://www.payfast.co.za/eng/process?' . '&'. $merchant_id .'&'. $merchant_key .'&'. $amount.'&'.  $item_name .'&'. $return_url .'&'. $cancel_url;
                return Redirect::away($url);
        }else{
            return back()->with('error', 'The company does not have sufficient credits.');
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
        $tunningcredit = TuningCredit::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        return view('tuning_credits.edit', compact('tunningcredit'));
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
        $tunningcredit = TuningCredit::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

        $this->validate($request, [
            'description' => 'required|numeric|min:1',
            'from' => 'required|numeric|min:1',
            'for' => 'required|numeric|min:1',
        ]);

        $tunningcredit->fill($request->all());
        $tunningcredit->save();

        return redirect()->route('tuning-credits.index')
            ->withSuccess('Tunning credit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tunningcredit = TuningCredit::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $tunningcredit->delete();

        // return back()->withSuccess("{$tunningcredit->credits} news deleted successfully.");
    }

    public function addGroup()
    {
        $credit_tiers = CredittierAmount::where([['company_id','=',checkDomain()]])->orderByRaw('amount asc')->get();
        return view('tuning_credits.add_group', compact('credit_tiers'));
    }
    public function editGroup($id)
    {
        $credit_group = CreditGroup::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $credit_tiers = CredittierAmount::where([['company_id','=',checkDomain()]])->orderByRaw('amount asc')->get();
        return view('tuning_credits.edit_group', compact('credit_tiers','credit_group'));
    }
    public function addGroupCredits(Request $request)
    {
        $credittier_check = CredittierAmount::where([['company_id','=',checkDomain()]])->get();

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        foreach ($credittier_check as $key => $value) {
            if($request->input('tier_from_'.$value->id) < 0 || !is_numeric($request->input('tier_from_'.$value->id))){
                $validator->errors()->add('tier_from_'.$value->id, 'The '.$value->id.' credit from must be at least 0.');
            }
            if($request->input('tier_for_'.$value->id) < 0 || !is_numeric($request->input('tier_for_'.$value->id))){
                $validator->errors()->add('tier_for_'.$value->id, 'The '.$value->id.' credit for must be at least 0.');
            }
        } 

        $credit_check = CreditGroup::where([['name', '=', $request->input('name')],['company_id','=',checkDomain()]])->get();

        if ($credit_check->count()) {
            $validator->errors()->add('name', 'The name has already been taken.');
        }

        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
        }

        $CreditGroup = new CreditGroup([
            'name' => $request->input('name'),
            'company_id' => checkDomain(),
        ]);

        $CreditGroup->save();

        foreach ($credittier_check as $key => $value) {
            $Credittier = new Credittier([
                'from' => $request->input('tier_from_'.$value->id),
                'for' => $request->input('tier_for_'.$value->id),
                'credit_group_id' => $CreditGroup->id,
                'credittier_amounts_id' => $value->id,
                'company_id' => checkDomain(),
            ]);
            $Credittier->save();
        }

        return redirect()->route('tuning-credits.index')
            ->withSuccess('Credit group created successfully.');

    }
    public function editGroupCredits(Request $request, $id)
    {
        $credittier_check = CredittierAmount::where([['company_id','=',checkDomain()]])->get();

        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        foreach ($credittier_check as $key => $value) {
            if($request->input('tier_from_'.$value->id) < 0 || !is_numeric($request->input('tier_from_'.$value->id))){
                $validator->errors()->add('tier_from_'.$value->id, 'The '.$value->id.' credit from must be at least 0.');
            }
            if($request->input('tier_for_'.$value->id) < 0 || !is_numeric($request->input('tier_for_'.$value->id))){
                $validator->errors()->add('tier_for_'.$value->id, 'The '.$value->id.' credit for must be at least 0.');
            }
        } 

        $credit_check = CreditGroup::where([['name', '=', $request->input('name')],['company_id','=',checkDomain()]])->whereNotIn('id',[$id])->get();

        if ($credit_check->count()) {
            $validator->errors()->add('name', 'The name has already been taken.');
        }

        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
        }

        
        $credit_group = CreditGroup::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $credit_group->name = $request->input('name');
        $credit_group->save();
        
        foreach ($credittier_check as $key => $value) {
            $credit_tier = Credittier::where([['credit_group_id', '=', $credit_group->id],['credittier_amounts_id','=',$value->id]])->firstOrFail();
            $credit_tier->from = $request->input('tier_from_'.$value->id);
            $credit_tier->for = $request->input('tier_for_'.$value->id);
            $credit_tier->save();
        }

        return redirect()->route('tuning-credits.index')
            ->withSuccess('Credit group updated successfully.');

    }
    public function addTier()
    {
        return view('tuning_credits.add_tier');
    }
    public function addTierCredits(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        $credit_check = CredittierAmount::where([['amount', '=', $request->input('amount')],['company_id','=',checkDomain()]])->get();

        if ($credit_check->count()) {
            $validator->errors()->add('amount', 'The amount has already been taken.');
        }

        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
        }


        $CredittierAmount = new CredittierAmount([
            'amount' => $request->input('amount'),
            'company_id' => checkDomain(),
        ]);

        $CredittierAmount->save();

        $credit_groups = CreditGroup::where([['company_id','=',checkDomain()]])->get();


        foreach ($credit_groups as $key => $credit_group) {
            $Credittier = new Credittier([
                // 'from' => $request->input('tier_from_'.$value->id),
                // 'for' => $request->input('tier_for_'.$value->id),
                'credit_group_id' => $credit_group->id,
                'credittier_amounts_id' => $CredittierAmount->id,
                'company_id' => checkDomain(),
            ]);
            $Credittier->save();
        }

        return redirect()->route('tuning-credits.index')
            ->withSuccess('Credit tier created successfully.');
    }

    public function deleteTier($id){
        $credittier = CredittierAmount::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $credittier->delete();
    }
    public function deleteGroup($id){
        $credit_group = CreditGroup::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $credit_group->delete();
    }
    public function editGroupDefault($id){
        $credit_group_change = CreditGroup::where([['company_id','=',checkDomain()]])->update(['default' => 0]);

        $credit_group = CreditGroup::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $credit_group->default = 1;
        $credit_group->save();
    }
}

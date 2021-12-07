<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\PaymentGetaway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class PaymentGetawaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_getaways =  DB::table('payment_getaways')->where([['company_id','=',auth('api')->user()->company_id]])->get();
        return response()->json(['success' => 'Successfully.',
         'errors' => '','payment_getaways'=> $payment_getaways], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment_getaways.create');
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
            'payment_name' => 'required',
            'payment_provider' => 'required',
            'merchant_id' => 'required',
            'merchant_key' => 'required'
        ]);

        $payment_check =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'],['company_id','=',auth('api')->user()->company_id]])->orderBy('updated_at', 'desc')->get();


        if ($payment_check->count()) {
            $validator->errors()->add('payment_provider', 'The payment provider has already been taken.');
        }

        if ($validator->errors()->messages()) {
            // return redirect()->back()->withErrors($validator)->withInput(request()->all());
            return response()->json(['success' => '',
         'errors' => $validator], 401);
        }


        $payment_getaway = new PaymentGetaway([
            'payment_name' => $request->input('payment_name'),
            'payment_provider' => $request->input('payment_provider'),
            'company_id' => \checkDomain(),
            'companyid' => 1,
            'merchant_id' => $request->input('merchant_id'),
            'merchant_key' => $request->input('merchant_key'),
        ]);

        $payment_getaway->save();

        return response()->json(['success' => 'Payment Successfully created.',
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $payment_getaway = PaymentGetaway::where('id', '=', $id)->firstOrFail();
        $payment_getaway =  DB::table('payment_getaways')->where([['id','=',$id],['company_id','=',auth('api')->user()->company_id]])->orderBy('updated_at', 'desc')->get()[0];

        return response()->json(['success' => 'Successfully',
         'errors' => '','payment_getaway' => $payment_getaway], 200);
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
        $payment_getaway = PaymentGetaway::where('id', '=',$id)->firstOrFail();
        
        $validator = Validator::make(request()->all(), [
            'payment_name' => 'required',
            'payment_provider' => 'required',
            'merchant_id' => 'required',
            'merchant_key' => 'required'
        ]);
        
        $payment_getaway->fill($request->only('payment_name'));
        $payment_getaway->fill($request->only('payment_provider'));
        $payment_getaway->fill($request->only('merchant_id'));
        $payment_getaway->fill($request->only('merchant_key'));

        $payment_getaway->save();

        return response()->json(['success' => 'Payment Successfully updated.',
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
        $payment_getaway = PaymentGetaway::where([['id','=',$id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();
        $payment_getaway->delete();

        return response()->json(['success' => 'Successfully',
         'errors' => ''], 201);
    }
}

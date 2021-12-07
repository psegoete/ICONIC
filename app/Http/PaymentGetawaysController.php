<?php

namespace CreatyDev\Http;

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

        if ($request->ajax()) {
            $data =  DB::table('payment_getaways')->where([['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
            
            return view('payment_getaways.index');
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

        $payment_check =  DB::table('payment_getaways')->where([['payment_provider', '=', 'payfast'],['company_id','=',checkDomain()]])->orderBy('updated_at', 'desc')->get();


        if ($payment_check->count()) {
            $validator->errors()->add('payment_provider', 'The payment provider has already been taken.');
        }

        if ($validator->errors()->messages()) {
            return redirect()->back()->withErrors($validator)->withInput(request()->all());
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

        return redirect()->route('payments.index')
            ->withSuccess('Package updated successfully.');
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
        $payment_getaway =  DB::table('payment_getaways')->where([['id','=',$id],['company_id','=',checkDomain()]])->orderBy('updated_at', 'desc')->get()[0];

       return view('payment_getaways.edit', compact('payment_getaway'));
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

        return redirect()->route('payments.index')
            ->withSuccess('Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_getaway = PaymentGetaway::where([['id','=',$id],['company_id','=',checkDomain()]])->firstOrFail();
        $payment_getaway->delete();

        // return back()->withSuccess("{$payment_getaway->version} package deleted successfully.");
    }
}

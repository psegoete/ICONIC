<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Users\Models\User;
use Illuminate\Support\Facades\Validator;



class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        if (auth('api')->user()->role == 'customer') {
            $transactions =  DB::table('transactions')->where([['user_id', '=', auth('api')->user()->id],['company_id','=', auth('api')->user()->company_id]])->get();
            return response()->json(['transactions' => $transactions,'errors' => '','success' => 'Successfully'], 200);
        } else {
            return response()->json(['errors' => 'Unauthorized','success' => ''], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth('api')->user()->role == 'admin') {

            $validate = Validator::make($request->all(), [
                'description' => 'required',
                'credits' => 'required|numeric',
                'user_id' => 'required',
                'action' => 'required',
            ]);
    
            if ($validate->errors()->count()) {
                return response()->json(['errors' => $validate->errors()], 401);
            }
    
            $UserTuningCredit = UserTuningCredit::where('user_id', '=', $request->input('user_id'))->get();
    
            if(!$UserTuningCredit->count()){
                $UserTuningCredit = new UserTuningCredit([
                    'credits' => 0,      
                    'user_id' => $request->input('user_id'),
                    'company_id' => auth('api')->user()->company_id,
                ]);
                $UserTuningCredit->save();
    
            }
            $UserTuningCredit = UserTuningCredit::where('user_id', '=', $request->input('user_id'))->get();
            $UserCompanyCredit = UserCompanyCredit::where('company_id', '=',auth('api')->user()->company_id )->get();
    
    
            if($request->input('action') == 'add'){
                
                $UserTuningCredit[0]->credits = $UserTuningCredit[0]->credits + $request->input('credits');
                $UserTuningCredit[0]->save();
    
                $UserCompanyCredit[0]->credits = $UserCompanyCredit[0]->credits - $request->input('credits');
                $UserCompanyCredit[0]->save();
    
                $transaction = new Transaction([
                    'credits' => $request->input('credits'),
                    'description' => $request->input('description'),
                    'status' => 'Completed',
                    'user_id' => $request->input('user_id'),
                    'company_id' => auth('api')->user()->company_id,
                ]);
                $transaction->save();
            }else if($request->input('action') == 'minus'){
                $UserTuningCredit[0]->credits = $UserTuningCredit[0]->credits - $request->input('credits');
                $UserTuningCredit[0]->save();
    
                $transaction = new Transaction([
                    'credits' => '-'.$request->input('credits'),
                    'description' => $request->input('description'),
                    'status' => 'Completed',      
                    'user_id' => $request->input('user_id'),
                    'company_id' => auth('api')->user()->company_id,
                ]);
                $transaction->save();
            }
            return response()->json(['user_id' => $request->input('user_id'),'success' => 'Successfully updated','errors'=>''], 200);
        }else{
            return response()->json(['success' => '','errors' => 'Unauthorized'], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if (auth('api')->user()->role == 'admin') {
            $transactions = DB::table('transactions')->where([['user_id', '=', $id],['company_id','=', auth('api')->user()->company_id]])->get();

            $customer = User::where([['id', '=', $id],['company_id','=', auth('api')->user()->company_id]])->first();
            if(!$customer){
                return response()->json(['errors' => 'Not found','success' => ''], 401);
            }
            return response()->json(['success' => 'Successfully','customer' => $customer, 'user_id' => $id,'transactions' => $transactions], 200);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $transaction = Transaction::where('id', '=', $id)->firstOrFail();
    //    return view('transaction.edit', compact('transaction'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $transaction = Transaction::where('id', '=',$id)->firstOrFail();

    //     $this->validate($request, [
    //         'credits' => 'required',
    //         'label' => 'required'
    //     ]);
        
    //     $transaction->fill($request->all());
    //     $transaction->save();

    //     return redirect()->route('transactions.index')
    //         ->withSuccess('Transaction updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth('api')->user()->role == 'admin') {
            $transaction = Transaction::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->first();
            if ($transaction) {
                $transaction->delete();
                return response()->json(['success' => 'You have successfully deleted'], 200);
            } else {
                return response()->json(['error' => 'Not found'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}

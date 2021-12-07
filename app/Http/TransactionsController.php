<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\Users\Models\User;



class TransactionsController extends Controller
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
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data =  DB::table('tuning_options')->where([['tuning_type_id', '=', $id],['company_id','=',checkDomain()]])->get();
            $data =  DB::table('transactions')->where([['user_id', '=', Auth::user()->id],['company_id','=', checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
        return view('transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tuning_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->input());

        $this->validate($request, [
            'description' => 'required',
            'credits' => 'required|numeric',
            'user_id' => 'required',
            'action' => 'required',
        ]);

        $UserTuningCredit = UserTuningCredit::where('user_id', '=', $request->input('user_id'))->get();

        if(!$UserTuningCredit->count()){
            $UserTuningCredit = new UserTuningCredit([
                'credits' => 0,      
                'user_id' => $request->input('user_id'),
                'company_id' => checkDomain(),
            ]);
            $UserTuningCredit->save();

        }
        $UserTuningCredit = UserTuningCredit::where('user_id', '=', $request->input('user_id'))->get();
        $UserCompanyCredit = UserCompanyCredit::where('company_id', '=',checkDomain() )->get();


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
                'company_id' => checkDomain(),
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
                'company_id' => checkDomain(),
            ]);
            $transaction->save();
        }

        

        return redirect()->route('transactions.show',$request->input('user_id'))
            ->withSuccess('Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $data = DB::table('transactions')->where([['user_id', '=', $id],['company_id','=', checkDomain()]])->get();
                return response()->json(['data' => $data]);
            }

            $customer = User::where([['id', '=', $id],['company_id','=', checkDomain()]])->firstOrFail();

            return view('transactions.show', compact('id','customer'));
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
        $transaction = Transaction::where('id', '=', $id)->firstOrFail();
       return view('transaction.edit', compact('transaction'));
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
        $transaction = Transaction::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'credits' => 'required',
            'label' => 'required'
        ]);
        
        $transaction->fill($request->all());
        //$gearboxe->fill($request->only('filename'));
        $transaction->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('transactions.index')
            ->withSuccess('Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('id', '=', $id)->firstOrFail();
        $transaction->delete();

        return back()->withSuccess("{$transaction->credits} company deleted successfully.");
    }
}

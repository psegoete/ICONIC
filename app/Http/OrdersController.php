<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Users\Models\User;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            if ($request->ajax()) {
                $data =  DB::table('orders')->where([['orders.company_id','=', checkDomain()]])
                ->join('invoices','invoices.id','=','orders.invoice_id')
                ->join('users','users.id','=','orders.user_id')
                ->groupBy('users.id','invoices.id','orders.id','orders.created_at','invoices.invoice_no','orders.status','orders.amount','users.first_name','users.last_name')
                ->select('orders.id as id','orders.created_at','invoices.invoice_no','orders.status','orders.amount','users.first_name','users.last_name')
                ->get();
                return response()->json(['data' => $data]);
            }
            return view('orders.index');
        }else{
            if ($request->ajax()) {
                $data =  DB::table('orders')->where([['user_id', '=', Auth::user()->id],['company_id','=', checkDomain()]])->get();
                return response()->json(['data' => $data]);
            }
            return view('orders.customer');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
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
            'order_no' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);

        $order = new Order([
            'order_no' => $request->input('order_no'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'status' => 'pending',
            'company_id' => \checkDomain(),
            'user_id' => auth::user()->id,
        ]);

        $order->save();

        return redirect()->route('orders.index')
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

        $order = Order::where('id', '=', $id)->firstOrFail();
        $user = User::where('id', '=', $order->user_id)->firstOrFail();

       return view('orders.edit', compact(['order'],['user']));
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
        $order = Order::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'status' => 'required',
        ]);
        
        // if( $request->input('status') == 'Completed' && $order->status != 'completed'){
        // }
        $order->fill($request->only('status'));
        $order->save();

        return redirect()->route('orders.index')
            ->withSuccess('Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::where('id', '=', $id)->firstOrFail();
        $order->delete();

        return back()->withSuccess("{$order->order_no} package deleted successfully.");
    }
}

<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Invoice;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Order;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Company\Models\Company;
use Yajra\Datatables\Datatables;


class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('invoices')->where([['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
            
            return view('invoices.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    public function download($id)
    {
        $company = Company::where('id', '=', checkDomain())->firstOrFail();
        $order = Order::where('id', '=', $id)->firstOrFail();
        $invoice = Invoice::where('id', '=', $order->invoice_id)->firstOrFail();
        $customer = User::where('id', '=', $order->user_id)->firstOrFail();


        $logo = url('/').'/logos/' .comapnyLogo();
        $pdf = PDF::loadView('pdf.pdf', compact(['order'],['invoice'],['customer'],['company'],['logo']));
        // return $pdf->stream();
        return $pdf->download($invoice->invoice_no . '.pdf');
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
            'invoice_no' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);

        $invoice = new Invoice([
            'invoice_no' => $request->input('invoice_no'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);

        $invoice->save();

        return redirect()->route('invoices.index')
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
        $invoice = Invoice::where('id', '=', $id)->firstOrFail();
       return view('invoices.edit', compact('invoice'));
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
        $invoice = Invoice::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'invoice_no' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);
        
        $invoice->fill($request->only('invoice_no'));
        $invoice->fill($request->only('description'));
        $invoice->fill($request->only('amount'));

        $invoice->save();

        return redirect()->route('invoices.index')
            ->withSuccess('invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::where('id', '=', $id)->firstOrFail();
        $invoice->delete();

        return back()->withSuccess("{$invoice->invice_no} package deleted successfully.");
    }
}

<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\tuningType;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class TuningOptionsController extends Controller
{
    public function index(Request $request, $id)
    {

        $tuning_type = tuningType::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_options =  DB::table('tuning_options')->where([['tuning_type_id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->get();
        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_options'=>$tuning_options, 'tuning_type'=>$tuning_type], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        return response()->json(['success' => 'Successfully',
         'errors' => '', 'tuning_type'=>$tuning_type], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $tuning_type = tuningType::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required',
            'tooltip' => 'required'
        ]);

        $tuning_option = new TuningOption([
            'credits' => $request->input('credits'),
            'label' => $request->input('label'),
            'tooltip' => $request->input('tooltip'),
            'tuning_type_id' => $request->input('tuning_type_id'),
            'company_id' => auth('api')->user()->company_id
        ]);

        $tuning_option->save();

        return response()->json(['success' => 'Successfully created',
         'errors' => '','tuning_type_id'=>$tuning_type->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tuning_option = TuningOption::where([['tuning_type_id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->get();
        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_option'=>$tuning_option], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($type_id, $id)
    {
        $tuning_type = tuningType::where([['id', '=', $type_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_option = TuningOption::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_option'=>$tuning_option ,'tuning_type'=>$tuning_type], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($type_id, Request $request, $id)
    {
        $tuning_type = tuningType::where([['id', '=', $type_id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_option = TuningOption::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required',
            'tooltip' => 'required'
        ]);

        $detail = $request->input('tooltip');
        $dom = new \DomDocument();



        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $detail = $dom->saveHTML();

        $tuning_option->tooltip = $detail;
        $tuning_option->fill($request->all());
        $tuning_option->save();

        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_type'=>$tuning_type->id], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tuid, $id)
    {
        $tuning_option = TuningOption::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $tuning_option->delete();

        return response()->json(['success' => 'Successfully',
         'errors' => ''], 201);
    }
}

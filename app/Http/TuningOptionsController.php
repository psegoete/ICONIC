<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\tuningType;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class TuningOptionsController extends Controller
{
    public function index(Request $request,$id)
    {

        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        if ($request->ajax()) {
            $data =  DB::table('tuning_options')->where([['tuning_type_id', '=', $id],['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
        return view('tuning_options.index', compact(['tuning_type']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        return view('tuning_options.create', compact(['tuning_type']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {

        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required',
            'tooltip' => 'required' 
        ]);

    //     $detail=$request->input('tooltip');
    //     $dom = new \DomDocument();



    //    $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    //    $detail = $dom->saveHTML();

        $tuning_option = new TuningOption([
            'credits' => $request->input('credits'),
            'label' => $request->input('label'),
            'tooltip' => $request->input('tooltip'),
            'tuning_type_id' => $request->input('tuning_type_id'),
            'company_id' => checkDomain()
        ]);

        $tuning_option->save();

        return redirect()->route('tuning_types.tuning_options.index', $tuning_type->id)
            ->withSuccess('Tunung option created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tuning_option = TuningOption::where([['tuning_type_id', '=', $id],['company_id','=',checkDomain()]])->get();
        return response()->json(['response' => $tuning_option]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($type_id,$id)
    {
        $tuning_type = tuningType::where([['id', '=', $type_id],['company_id','=',checkDomain()]])->firstOrFail();
        $tuning_option = TuningOption::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
       return view('tuning_options.edit', compact(['tuning_option'],['tuning_type']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($type_id,Request $request, $id)
    {
        $tuning_type = tuningType::where([['id', '=', $type_id],['company_id','=',checkDomain()]])->firstOrFail();
        $tuning_option = TuningOption::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required',
            'tooltip' => 'required'
        ]);
        
        $detail=$request->input('tooltip');
        $dom = new \DomDocument();



       $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

       $detail = $dom->saveHTML();
        
        $tuning_option->tooltip = $detail;
        $tuning_option->fill($request->all());
        $tuning_option->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('tuning_types.tuning_options.index',$tuning_type->id)
            ->withSuccess('Tuning options updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tuid,$id)
    {
        $tuning_option = TuningOption::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $tuning_option->delete();

        // return back()->withSuccess("{$tuning_option->label}  deleted successfully.");
    }
}

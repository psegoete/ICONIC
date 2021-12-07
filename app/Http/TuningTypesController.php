<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\tuningType;
use CreatyDev\Domain\TuningOption;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Faker\Factory as Faker;

class TuningTypesController extends Controller
{
    public function index(Request $request)
    {
        return view('tuning_types.index');
    }

    public function getTuningTypes(Request $request)
    {
        $data =  DB::table('tuning_types')->where([['tuning_types.company_id','=',checkDomain()]])
        ->leftJoin('tuning_options','tuning_types.id','=','tuning_options.tuning_type_id')
        ->select('tuning_types.label','tuning_types.credits','tuning_types.id',DB::raw('COUNT(tuning_options.id) as total'))
        ->groupBy('tuning_types.id','tuning_types.label','tuning_types.credits')
        ->get();

            return response()->json(['data' => $data]);
            
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

      
        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required'
        ]); 

        $tuning_type = new tuningType([
            'credits' => $request->input('credits'),
            'label' => $request->input('label'),
            'company_id' => checkDomain()
        ]);

        // dd( $request->input('label'));

        $tuning_type->save();

        return redirect()->route('tuning_types.index')
            ->withSuccess('Tunung type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
       return view('tuning_types.edit', compact('tuning_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
       return view('tuning_types.edit', compact('tuning_type'));
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
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required'
        ]);
        
        $tuning_type->fill($request->all());
        //$gearboxe->fill($request->only('filename'));
        $tuning_type->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('tuning_types.index')
            ->withSuccess('Tuning type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $tuning_type->delete();

        // return back()->withSuccess("{$tuning_type->credits} company deleted successfully.");
    }
}

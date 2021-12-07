<?php

namespace CreatyDev\Http\api;
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
        $tuning_types =  DB::table('tuning_types')->where([['tuning_types.company_id','=',auth('api')->user()->company_id]])
        ->leftJoin('tuning_options','tuning_types.id','=','tuning_options.tuning_type_id')
        ->select('tuning_types.label','tuning_types.credits','tuning_types.id',DB::raw('COUNT(tuning_options.id) as total'))
        ->groupBy('tuning_types.id','tuning_types.label','tuning_types.credits')
        ->get();

        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_types'=>$tuning_types], 200);
            
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
            'company_id' => auth('api')->user()->company_id
        ]);

        // dd( $request->input('label'));

        $tuning_type->save();

        return response()->json(['success' => 'Tunung type created successfully.',
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
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();
        
        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_type'=>$tuning_type], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();

        return response()->json(['success' => 'Successfully',
         'errors' => '','tuning_type'=>$tuning_type], 200);
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
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();

        $this->validate($request, [
            'credits' => 'required|numeric|min:0',
            'label' => 'required'
        ]);
        
        $tuning_type->fill($request->all());
        $tuning_type->save();

        return response()->json(['success' => 'Tunung type updated successfully.',
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
        $tuning_type = tuningType::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();
        $tuning_type->delete();

        return response()->json(['success' => 'Tunung type dleted successfully.',
         'errors' => ''], 201);
    }
}

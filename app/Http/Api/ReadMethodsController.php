<?php

namespace CreatyDev\Http\api;
use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\ReadMethod;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use CreatyDev\Domain\Make;

class ReadMethodsController extends Controller
{
    //
    public function index(Request $request)
    {
        $read_methods =  DB::table('read_methods')->where([['company_id','=',auth('api')->user()->company_id]])->get();
        return response()->json(['success' => 'Successfully',
         'errors' => '','read_methods'=>$read_methods], 200);
    }

    public function create()
    {
        return view('readmethods.create');
    }


    //

    public function store(Request $request)
    {
        $this->validate($request, [
            'read_method_name' => 'required'
        ]);

        $readmethod = new ReadMethod([
            'read_method_name' => $request->input('read_method_name'),
            'company_id' => \checkDomain()
        ]);

        $readmethod->save();

        return response()->json(['success' => 'ReadMethod created successfully.',
         'errors' => ''], 201);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();

        return response()->json(['success' => 'Successfully',
         'errors' => '', 'readmethod' =>$readmethod], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {

        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();

        $this->validate($request, [
            'read_method_name' => 'required'
        ]);
        
        $readmethod->fill($request->only('read_method_name'));
        //$gearboxe->fill($request->only('filename'));
        $readmethod->save();

        return response()->json(['success' => 'Successfully updated',
         'errors' => ''], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',auth('api')->user()->company_id]])->firstOrFail();
        $readmethod->delete();

        return response()->json(['success' => 'Successfully',
         'errors' => ''], 201);
    }
}

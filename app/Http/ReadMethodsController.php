<?php

namespace CreatyDev\Http;

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

        if ($request->ajax()) {
            $data =  DB::table('read_methods')->where([['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
            
        return view('readmethods.index');
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

        return redirect()->route('readmethods.index')
            ->withSuccess('ReadMethod created successfully.');
    }

    public function show($id,$name)
    {
        $make = new Make([
            'make_id' => $id,
            'name' => $name,
        ]);
        $make->save();
        return response()->json($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
       return view('readmethods.edit', compact('readmethod'));
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

        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

        $this->validate($request, [
            'read_method_name' => 'required'
        ]);
        
        $readmethod->fill($request->only('read_method_name'));
        //$gearboxe->fill($request->only('filename'));
        $readmethod->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('readmethods.index')
            ->withSuccess('ReadMethod updated successfully.');
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
        $readmethod = ReadMethod::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $readmethod->delete();

        // return back()->withSuccess("{$readmethod->gbName} readmethod deleted successfully.");
    }
}

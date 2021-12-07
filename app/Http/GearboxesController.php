<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Gearboxe;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


class GearboxesController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('gearboxes')->where([['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
            
            return view('gearboxes.index');
    }

    public function create()
    {
        return view('gearboxes.create');
    }


    //

    public function store(Request $request)
    {
        $this->validate($request, [
            'gbName' => 'required'
        ]);

        $gearboxe = new Gearboxe([
            'gbName' => $request->input('gbName'),
            'company_id' => checkDomain(),
        ]);

        $gearboxe->save();

        return redirect()->route('gearboxes.index')
            ->withSuccess('Gearbox created successfully.');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gearbox = Gearboxe::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
       return view('gearboxes.edit', compact('gearbox'));
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

        $gearboxe = Gearboxe::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

        $this->validate($request, [
            'gbName' => 'required'
        ]);
        
        $gearboxe->fill($request->only('gbName'));
        //$gearboxe->fill($request->only('filename'));
        $gearboxe->save();

        // return back()->withSuccess('Gearboxe updated successfully.');
        return redirect()->route('gearboxes.index')
            ->withSuccess('Gearboxe updated successfully.');
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
        $gearboxe = Gearboxe::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $gearboxe->delete();

        // return back()->withSuccess("{$gearboxe->gbName} gearboxe deleted successfully.");
    }
}

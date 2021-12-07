<?php

namespace CreatyDev\Http\api;

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
        $data =  DB::table('gearboxes')->where([['company_id', '=', auth('api')->user()->company_id]])->get();
        return response()->json(['data' => $data], 200);
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
            'company_id' => auth('api')->user()->company_id,
        ]);

        $gearboxe->save();

        return response()->json(['success' => 'Gearbox created successfully.', 'errors' => ''], 200);

        // return redirect()->route('gearboxes.index')
        //     ->withSuccess('Gearbox created successfully.');
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
        $gearbox = Gearboxe::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        return response()->json(['success' => 'Successfully.',
         'errors' => '',
        'gearbox' => $gearbox ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \CreatyDev\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        $gearboxe = Gearboxe::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $this->validate($request, [
            'gbName' => 'required'
        ]);

        $gearboxe->fill($request->only('gbName'));
        $gearboxe->save();

        return response()->json(['success' => 'Gearbox updated successfully.',
         'errors' => ''], 200);
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
        $gearboxe = Gearboxe::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        $gearboxe->delete();

        return response()->json(['success' => 'Gearbox deleted successfully.',
         'errors' => ''], 201);
    }
}

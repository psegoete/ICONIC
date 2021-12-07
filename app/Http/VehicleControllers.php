<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Make;

class VehicleControllers extends Controller
{
    public function store(Request $request)
    {
        $make = new Make([
            'make_id' => $request->input('make_id'),
            'name' => $request->input('name'),
        ]);
        $make->save();

        return response()->json(['data' => $make]);
    }

    public function model(Request $request)
    {
        //
    }

    public function generation(Request $request)
    {
        //
    }

    public function engine(Request $request)
    {
        //
    }

    public function show($id)
    {
        return response()->json($id);
    }
}

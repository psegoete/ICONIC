<?php

namespace CreatyDev\Http\Api\Controllers;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Make;
use CreatyDev\Domain\carModel;
use CreatyDev\Domain\Generation;
use CreatyDev\Domain\Engine;
use CreatyDev\Domain\Logo;


class makeControllers extends Controller
{
    public function index(Request $request)
    {
        $makes = Make::all();
        return response()->json($makes, 200);
    }

    public function model(Request $request, $make_id)
    {
        $models = CarModel::where([['make_id', '=', $make_id]])->get();
        return response()->json($models, 200);
    }

    public function generation(Request $request, $model_id)
    {
        $generations = Generation::where([['model_id', '=', $model_id]])->get();
        return response()->json($generations, 200);
    }

    public function engine(Request $request, $generation_id)
    {
        $engines = Engine::where([['generation_id', '=', $generation_id]])->get();
        return response()->json($engines, 200);
    }

    public function engineAll(Request $request)
    {
        $engines = Engine::all();
        return response()->json($engines, 200);
    }

    public function engineData(Request $request, $engine_id)
    {
        $engine = Engine::where([['engine_id', '=', $engine_id]])->get();
        return response()->json($engine, 200);
    }

    public function Logo(Request $request, $make_id)
    {
        $logo = Logo::where([['make_id', '=', $make_id]])->get();

        return response()->json($logo, 200);
    }

    public function modelGeneration($model_id, $generation_id, $name, $long_name, $start_year, $start_month, $end_month, $end_year)
    {
        $generation = new Generation([
            'model_id' => $model_id,
            'generation_id' => $generation_id,
            'name' => $name,
            'long_name' => $long_name,
            'start_year' => $start_year,
            'start_month' => $start_month,
            'end_month' => $end_month,
            'end_year' => $end_year,
        ]);
        $generation->save();

        return response()->json($generation, 200);
    }

    public function generationEngine($generation_id, $engine_id, $code, $name, $fuel_type, $power, $torgue, $flag)
    {
        $engine = new Engine([
            'generation_id' => $generation_id,
            'engine_id' => $engine_id,
            'name' => $name,
            'code' => $code,
            'fuel_type' => $fuel_type,
            'power' => $power,
            'torgue' => $torgue,
            'flag' => $flag,
        ]);
        $engine->save();

        return response()->json($engine, 200);
        dd('wddf');
    }

    public function store(Request $request)
    {
        // $article = Make::create($request->all());
        return response()->json($request->all(), 200);
    }
}

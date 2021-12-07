<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('api')->user()->role == 'admin') {
            $news =  DB::table('news')->where([['company_id', '=', auth('api')->user()->company_id]])->get();
            return response()->json(['news' => $news], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth('api')->user()->role == 'admin') {

            $todayDate = date('Y-m-d', strtotime('+2 years'));
            $validate = Validator::make($request->all(), [
                'title' => 'required',
                'display_date' => 'required|date_format:Y-m-d|before:' . $todayDate,
                'contents' => 'required',
                'visibility' => 'required',

            ], [
                'display_date.before' => 'The year should not be more than two years',
            ]);

            if ($validate->errors()->count()) {
                return response()->json(['errors' => $validate->errors()], 401);
            }

            $news = new News([
                'title' => $request->input('title'),
                'display_date' => $request->input('display_date'),
                'contents' => $request->input('contents'),
                'company_id' => auth('api')->user()->company_id,
                'visibility' => $request->input('visibility'),
            ]);

            $news->save();
            return response()->json(['You have successfully created news'], 201);
        }

        return response()->json(['You are not authorized to create news'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();
        return response()->json(['news' => $news], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = News::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->firstOrFail();

        $todayDate = date('Y-m-d', strtotime('+2 years'));

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'display_date' => 'required|date_format:Y-m-d|before:' . $todayDate,
            'contents' => 'required',
            'visibility' => 'required',

        ], [
            'display_date.before' => 'The year should not be more than two years',
        ]);

        if ($validate->errors()->count()) {
            return response()->json(['errors' => $validate->errors()], 401);
        }

        $news->fill($request->all());
        $news->save();

        return response()->json(['You have successfully updated news'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth('api')->user()->role == 'admin') {
            $news = News::where([['id', '=', $id], ['company_id', '=', auth('api')->user()->company_id]])->first();
            if ($news) {
                $news->delete();
                return response()->json(['success' => 'You have successfully deleted'], 200);
            } else {
                return response()->json(['error' => 'Not found'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}

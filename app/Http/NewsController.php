<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('news')->where([['company_id','=',checkDomain()]])->get();
            return response()->json(['data' => $data]);
        }
            
        return view('news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todayDate = date('Y-m-d', strtotime('+2 years'));
        $this->validate($request, [
            'title' => 'required',
            'display_date' => 'date_format:Y-m-d|before:'.$todayDate,
            'contents' => 'required',
            'visibility' => 'required',

        ],[
            'display_date.before' => 'The year should not be more than two years',
        ]);

        $news = new News([
            'title' => $request->input('title'),
            'display_date' => $request->input('display_date'),
            'contents' => $request->input('contents'),
            'company_id' => checkDomain(),
            'visibility' => $request->input('visibility'),
        ]);

        $news->save();

        return redirect()->route('news.index')
            ->withSuccess('News created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $news = News::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();

    //    dd(\Carbon\Carbon::parse($news->display_date)->isoFormat('YYYY/MM/DD'));
       return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $news = News::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        // dd($request->input('display_date'));
        // $this->validate($request, [
        //     'title' => 'required',
        //     'display_date' => 'required',
        //     'contents' => 'required',
        //     'visibility' => 'required',
        // ]);

        $todayDate = date('Y-m-d', strtotime('+2 years'));
        $this->validate($request, [
            'title' => 'required',
            'display_date' => 'date_format:Y-m-d|before:'.$todayDate,
            'contents' => 'required',
            'visibility' => 'required',

        ],[
            'display_date.before' => 'The year should not be more than two years',
        ]);

        $news->fill($request->all());
        $news->save();

        return redirect()->route('news.index')
            ->withSuccess('ReadMethod updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $news = News::where([['id', '=', $id],['company_id','=',checkDomain()]])->firstOrFail();
        $news->delete();

        // return back()->withSuccess("{$news->title} news deleted successfully.");
    }
}

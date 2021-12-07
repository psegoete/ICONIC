<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Package;
use Illuminate\Support\Facades\DB;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('search')){
            $packages =  DB::table('packages')->where('package_name', 'like', '%'.$request->get('search').'%')->orderBy('updated_at', 'desc')->paginate(10);
        }else{
            $packages =  DB::table('packages')->orderBy('updated_at', 'desc')->paginate(10);
        }

        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        return view('packages.create');
    }


    //

    public function store(Request $request)
    {
        $this->validate($request, [
            'package_name' => 'required',
            'package_description' => 'required',
            'price' => 'required'
        ]);

        $package = new Package([
            'package_name' => $request->input('package_name'),
            'package_description' => $request->input('package_description'),
            'price' => $request->input('price')
        ]);

        $package->save();

        return redirect()->route('packages.index')
            ->withSuccess('Package created successfully.');
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
        $package = Package::where('id', '=', $id)->firstOrFail();
       return view('packages.edit', compact('package'));
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

        $package = Package::where('id', '=',$id)->firstOrFail();

        $this->validate($request, [
            'package_name' => 'required',
            'package_description' => 'required',
            'price' => 'required'
        ]);
        
        $package->fill($request->only('package_name'));
        $package->fill($request->only('package_description'));
        $package->fill($request->only('price'));

        $package->save();

        return redirect()->route('packages.index')
            ->withSuccess('Package updated successfully.');
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
        $package = Package::where('id', '=', $id)->firstOrFail();
        $package->delete();

        return back()->withSuccess("{$package->package_name} package deleted successfully.");
    }
}

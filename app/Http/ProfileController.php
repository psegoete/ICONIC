<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Users\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('profiles.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockOrUnblock($id)
    {
        if(Auth::user()->role == 'admin'){

            $user = User::findOrFail($id);
            if($user->blocked == '1'){
                $user->blocked = 0;
                $user->save();
                return back()->with('success', 'Successfully unblocked ' . $user->name);
            }else{
                $user->blocked = 1;
                $user->save();
                return back()->with('success', 'Successfully blocked ' . $user->name);
            }
        }
       
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
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        

        $user = User::findOrFail($id);

        $user->first_name = $request->input('first_name') ;
        $user->last_name = $request->input('last_name') ;
        $user->username = $request->input('username') ;
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if($request->input('password')){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();


        return redirect()->back()->with("status", "User has been updated.");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

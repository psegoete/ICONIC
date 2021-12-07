<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\PassworRecover;

class ResetPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showResetForm(Request $request, $token = null)
    {

        $PassworRecover = PassworRecover::where([['token', '=', $token],['company_id','=',checkDomain()]])->firstOrFail();
        // dd( $PassworRecover->id);
        // $user = User::where([['id', '=', $PassworRecover->id]])->firstOrFail();
        $user = User::where([['id', '=', $PassworRecover->user_id],['company_id','=',checkDomain()]])->get();

        return view('forgot_password.reset_password', compact('token'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6',
        ]);


        

        $PassworRecover = PassworRecover::where([['token', '=', $request->input('token')],['company_id','=',checkDomain()]])->firstOrFail();
        $user = User::where([['id', '=', $PassworRecover->user_id]])->firstOrFail();

            if($PassworRecover->status == '0'){
                if(!preg_match('/[a-z]/', $request['password'])){
                    return back()->with('error', 'Must contain at least one lowercase letter.');
                }
                if(!preg_match('/[A-Z]/', $request['password'])){
                    return back()->with('error', 'Must contain at least one uppercase  letter.');
                }
                if(!preg_match('/[0-9]/', $request['password'])){
                    return back()->with('error', 'Must contain at least one digit.');
                }
                if(!preg_match('/[?=.*?[#?!@$%^&*-]/', $request['password'])){
                    return back()->with('error', 'Must contain a special character.');
                }
        
                if($request->input('password')){
                    $user->password = bcrypt($request->input('password'));
                }
                $user->save();
                $PassworRecover->status = 1;
                $PassworRecover->save();
        
                return redirect('/')
                    ->withSuccess('User created successfully.');
            }else {
                return back()->with('error', 'The forgot password has expired');
            }
    }
    
    public function index()
    {
        //
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
    public function edit($id)
    {
        //
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
        //
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

<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuperLoginController extends Controller
{
    public function login()
    {
        return view('login.super_login');
    }

    public function store()
    {
        return view('login.super_login');
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

            
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'role' => 'super-admin']) == true) {
            // Authentication passed...
            return redirect('super-admin/dashboard');
        }else{
            $validator->errors()->add('email', 'These credentials do not match our records.');
            return redirect()->back()->with('error','These credentials do not match our records.');
            // ->with('error','Not sending mail.. retry again...')
        }
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}

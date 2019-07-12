<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //return true;

        $this->validate($request, [
            'email' =>'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            return redirect()->intended(route('admin.dashboard'));//if success the redirect to the dashboard
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function loginsetup(Request $request){
        return view('layouts.login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            switch(Auth::user()->Usertype){
                case 1:
                    return redirect()->intended('admin/crew');
                case 2:
                    return redirect()->intended('crew/dashboard');
                case 3:
                    return redirect()->intended('staff/dashboard');
            }
        }
        return back()->withErrors([
            'err' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

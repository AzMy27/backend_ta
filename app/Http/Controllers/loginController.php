<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class loginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function submit(Request $request)    
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}

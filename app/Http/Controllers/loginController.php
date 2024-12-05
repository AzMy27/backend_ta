<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class loginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->isKecamatan()){
                return redirect()->route('admin.dashboard');
            }elseif($user->isDesa()){
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
        }
        return view('auth.login');
    }

    public function submit(Request $request)    
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $credentials = $request->only('email','password');

        $credentials['level'] = ['kecamatan','desa'];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->isKecamatan()){
                return redirect()->route('admin.dashboard');
            }elseif($user->isDesa()){
                return redirect()->route('admin.dashboard');
            }
        }else{
            return back()->with('warning','Login gagal username dan password tidak ditemukan');
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}

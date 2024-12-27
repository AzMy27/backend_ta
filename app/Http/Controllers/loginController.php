<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Hash;


class loginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->level == 'admin'){
                return redirect()->route('admin.dashboard');
            }elseif($user->isKecamatan()){
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

        $credentials['level'] = ['kecamatan','desa','admin'];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->level =='admin'){
                return redirect()->route('admin.dashboard');
            }elseif($user->isKecamatan()){
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

    public function changePage()
    {
        return view('password.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|min:8|confirmed',
        ]);
        $user = Auth::user();

        if(!Hash::check($request->old_password, $user->password)){
            return back()->with('warning','Password lama tidak sesuai');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('success', 'Password berhasil diubah');
    }
}

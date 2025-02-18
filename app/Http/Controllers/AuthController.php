<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->isAdmin()){
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return back()->with('warning', 'Pengguna tidak tersedia');
        }
        if(!Hash::check($request->password, $user->password)){
            return back()->with('warning', 'Password salah');
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); 

        $credentials['level'] = ['kecamatan', 'desa', 'admin'];

        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            $user = Auth::user();
            
            if($user->level == 'admin'){
                return redirect()->route('admin.dashboard');
            }elseif($user->isKecamatan()){
                return redirect()->route('admin.dashboard');
            }elseif($user->isDesa()){
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->with('warning', 'Anda tidak dapat mengakses halaman ini');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return to_route('login');
    }
}
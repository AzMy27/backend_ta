<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kecamatan;

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

    public function registerKecamatan(){
        return view('auth.regist');
    }

    public function kecamatanStore(Request $request) {
        $dataKecamatan = $request->validate([
            'name_koordinator' => 'required',
            'nama_kecamatan' => 'required',
            'no_telp_koordinator' => 'required',
        ]);

        $dataKecamatan['user_id'] = User::create([
            'name' => $request->nama_koordinator,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'kecamatan',
        ])->id;

        Auth::user()->kecamatan()->create($dataKecamatan);

        return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');
    }
}

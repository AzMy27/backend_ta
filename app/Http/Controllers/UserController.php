<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('auth.regist');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'kecamatan',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');
    }
}

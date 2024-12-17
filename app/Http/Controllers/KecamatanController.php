<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{
    public function onlyAdmin(){
        $user = Auth::user();
        if ($user->level != 'admin') {
            return redirect()->route('admin.dashboard')->send();
        }
    }

    public function index()
    {
        $this->onlyAdmin();
        $dataKecamatan = Kecamatan::get();
        return view('kecamatan.index', ['dataKecamatan' => $dataKecamatan]);
    }


    public function create()
    {
        $this->onlyAdmin();
        return view('kecamatan.create');
    }

    public function store(Request $request)
    {
        $this->onlyAdmin();
        $kecamatan = $request->validate([
            'nama_kecamatan'=>'required',
            'nama_koordinator'=>'required',
            'no_telp_koordinator' => 'required',
        ]);
        $kecamatan['user_id'] = User::create([
            'name' => $request->nama_koordinator,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'kecamatan',
        ])->id;
        
        Kecamatan::create($kecamatan);
        return redirect()->route('kecamatan.index')->with('success', 'Data Kecamatan Berhasil Ditambah');
    }

    public function show(Kecamatan $kecamatan)
    {
        //
    }

    public function edit(Kecamatan $kecamatan)
    {
        //
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        //
    }

    public function destroy(Kecamatan $kecamatan)
    {
        //
    }
}

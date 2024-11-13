<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataDesa= Desa::get();
        return view('desa.index',['dataDesa'=>$dataDesa]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataDesa=$request->validate([
            'nama_desa'=>'required',
            'nama_kepala'=>'required',
            'no_telp_desa'=>'required',
        ]);
       $dataDesa['user_id'] = User::create([
            'name'=>$request->nama_kepala,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'level'=>'desa',
       ])->id;
        Auth::user()->kecamatan->desa()->create($dataDesa);
        return redirect()->route('desa.index')->with('success','Data Desa Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {
        //
    }
}

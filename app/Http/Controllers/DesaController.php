<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DesaController extends Controller
{
    public function index()
    {
        $kecamatan = Auth::user()->kecamatan;
        $dataDesa = $kecamatan->desa;

        return view('desa.index',['dataDesa'=>$dataDesa]);
    }

    public function create()
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan_id) {
            abort(403, 'Unauthorized access');
        }
        return view('desa.create');
    }

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

    public function show(Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan_id) {
            abort(403, 'Unauthorized access');
        }
        return view('desa.show',['dataDesa'=>$desa]);
    }

    public function edit(Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan_id) {
            abort(403, 'Unauthorized access');
        }
        return view('desa.edit',['dataDesa'=>$desa]);
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
        if ($desa->kecamatan_id !== Auth::user()->kecamatan_id) {
            abort(403, 'Unauthorized access');
        }
        $desa->delete();
        return redirect()->route('desa.index')->with('success', 'Data Desa Berhasil Dihapus');
    }
}

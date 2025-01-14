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

        return view('desa.index', ['dataDesa' => $dataDesa]);
    }

    public function create()
    {
        return view('desa.create');
    }

    public function store(Request $request)
    {
        $dataDesa = $request->validate([
            'nama_desa' => 'required',
            'nama_kepala' => 'required',
            'no_telp_desa' => 'required|numeric',
        ],[
            'nama_desa.required' => 'Nama Desa Wajib Diisi',
            'nama_kepala.required' => 'Nama Kepala Desa Wajib Diisi',
            'no_telp_desa.required' => 'No Telp Desa Wajib Diisi',
            'no_telp_desa.numeric' => 'No Telp Desa Harus berupa angka'
        ]);
        
        $dataDesa['user_id'] = User::create([
            'name' => $request->nama_kepala,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'desa',
        ])->id;
        $dataDesa['kecamatan_id'] = Auth::user()->kecamatan->id;

        Auth::user()->kecamatan->desa()->create($dataDesa);
        return redirect()->route('desa.index')->with('success', 'Data Desa Berhasil Ditambah');
    }

    public function show(Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('desa.show', ['dataDesa' => $desa]);
    }

    public function edit(Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('desa.edit', ['dataDesa' => $desa]);
    }

    public function update(Request $request, Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        $dataDesa = $request->validate([
            'nama_desa' => 'required',
            'nama_kepala' => 'required',
            'no_telp_desa' => 'required|numeric',
        ],[
            'nama_desa.required' => 'Nama Desa Wajib Diisi',
            'nama_kepala.required' => 'Nama Kepala Desa Wajib Diisi',
            'no_telp_desa.required' => 'No Telp Desa Wajib Diisi',
            'no_telp_desa.numeric' => 'No Telp Desa Harus berupa angka',
        ]);

        $desa->update($dataDesa);

        if($desa->user){
            $desa->user->update([
                'name' => $dataDesa['nama_kepala'] ?? $desa->nama_kepala,
            ]);
        }

        return to_route('desa.index')->with('success', 'Data desa berhasil diperbarui');
    }

    public function destroy(Desa $desa)
    {
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($desa->user) {
            $desa->user->delete();
        }
        
        $desa->delete();
        return redirect()->route('desa.index')->with('success', 'Data Desa Berhasil Dihapus');
    }
}

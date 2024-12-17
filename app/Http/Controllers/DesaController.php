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
            'no_telp_desa' => 'required',
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
        // Cek apakah desa ini milik kecamatan yang sedang login
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('desa.show', ['dataDesa' => $desa]);
    }

    public function edit(Desa $desa)
    {
        // Cek apakah desa ini milik kecamatan yang sedang login
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('desa.edit', ['dataDesa' => $desa]);
    }

    public function update(Request $request, Desa $desa)
    {
        // Cek apakah desa ini milik kecamatan yang sedang login
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'nama_desa' => 'required',
            'nama_kepala' => 'required',
            'no_telp_desa' => 'required',
        ]);

        $desa->update($validatedData);

        // Update user data jika ada perubahan
        if ($request->filled('email') || $request->filled('password')) {
            $userData = [];
            if ($request->filled('email')) {
                $userData['email'] = $request->email;
            }
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            $desa->user->update($userData);
        }

        return redirect()->route('desa.index')->with('success', 'Data Desa Berhasil Diupdate');
    }

    public function destroy(Desa $desa)
    {
        // Cek apakah desa ini milik kecamatan yang sedang login
        if ($desa->kecamatan_id !== Auth::user()->kecamatan->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus user terkait jika ada
        if ($desa->user) {
            $desa->user->delete();
        }
        
        $desa->delete();
        return redirect()->route('desa.index')->with('success', 'Data Desa Berhasil Dihapus');
    }
}

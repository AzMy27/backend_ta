<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Dai;
use App\Models\Desa;
use Illuminate\Support\Facades\Auth;

class DaiController extends Controller
{
    public function index()
    {
        $user=Auth::user();
        if($user->level=='kecamatan'){
            $data = Dai::whereHas('desa',function($query)use($user){
                $query->where('kecamatan_id',$user->kecamatan->id);
            })->get();
        }else{
            $desaId = $user->desa->id;
            $data = Dai::where('desa_id', $desaId)->get();
        }
        return view('dai.index',['data'=>$data]);
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->level == 'kecamatan') {
            $desaList = Desa::where('kecamatan_id', $user->kecamatan->id)->get();
        } else {
            $desaList = [$user->desa];
        }
        return view('dai.create', compact('desaList'));
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'nik'=>'required|unique:dais,nik|digits:16|numeric',
            'nama'=>'required',
            'no_hp'=>'required|numeric',
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'rt'=>'required|numeric',
            'rw'=>'required|numeric',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image|mimes:jpeg,png,jpg,jfif,gif|max:2048',
            'desa_id' => 'exists:desas,id',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar. Gunakan NIK lain.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.required' => 'Nik harus diisi',
            'nama.required' => 'Nama harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka.',
            'no_hp.required' => 'No HP harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'tanggal_lahir.date' => 'Tanggal Lahir harus berupa tanggal.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'rt.required' => 'RT harus diisi',
            'rt.numeric' => 'RT harus berupa angka',
            'rw.required' => 'RW harus diisi',
            'rw.numeric' => 'RW harus berupa angka',
            'pendidikan_akhir.required' => 'Pendidikan Akhir harus diisi.',
            'status_kawin.required' => 'Status Kawin harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email ini sudah terdaftar. Gunakan email lain.',
            'email.email' => 'Email harus berupa email.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus minimal 8 huruf.',
            'foto_dai.image' => 'File harus berupa gambar.',
            'foto_dai.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'foto_dai.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]); 
        if($request->hasFile('foto_dai')){
            $data['foto_dai'] =  $request->file('foto_dai')->store('foto_dai','public');
        }

        $user = Auth::user();
        if($user->level == 'kecamatan'){
            $desaId = $request->input('desa_id');
            $data['desa_id']=$desaId;
        }else{
            $data['desa_id']=$user->desa->id;
        }
        $dataDai=Dai::create($data);

        if($dataDai){
            if(!$dataDai->user()->exists()){
               $userDai = $dataDai->user()->create([
                    'name'=>$request->nama,
                    'image'=>$data['foto_dai'] ?? null,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'level'=>'dai',
                ]);
                $dataDai->update([
                    'user_id'=>$userDai->id,
                ]);              
            }
        }
        return to_route('dai.index')->with('success','Data Berhasil Ditambah');
    }

    public function show(Dai $dai)
    {
        $user = Auth::user();
        if($user->level =='kecamatan'){
            $allowedDesaId = Desa::where('kecamatan_id',$user->kecamatan->id)->pluck('id');
            if(!$allowedDesaId->contains($dai->desa_id)){
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk melihat data DAI dari desa lain.');
            }
        }
        else{
            if($dai->desa_id !== $user->desa->id){
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk melihat data DAI dari desa lain.');
            }
        }
        return view('dai.show',['data'=>$dai]);
    }

    public function edit(Dai $dai)
    {
        $user = Auth::user();
        if ($user->level == 'kecamatan') {
            $allowedDesaIds = Desa::where('kecamatan_id', $user->kecamatan->id)->pluck('id');
            if (!$allowedDesaIds->contains($dai->desa_id)) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk mengedit data DAI dari desa lain.');
            }
        } 
        else {
            if ($dai->desa_id !== $user->desa->id) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk mengedit data DAI dari desa lain.');
            }
        }
        return view('dai.edit',['data'=>$dai]);
    }

    public function update(Request $request, Dai $dai)
    {
        $user = Auth::user();
        if ($user->level == 'kecamatan') {
            $allowedDesaIds = Desa::where('kecamatan_id', $user->kecamatan->id)->pluck('id');
            if (!$allowedDesaIds->contains($dai->desa_id)) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk mengubah data DAI dari desa lain.');
            }
        } 
        else {
            if ($dai->desa_id !== $user->desa->id) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk mengubah data DAI dari desa lain.');
            }
        }
        $data=$request->validate([
            // 'nik'=>'required|digits:16',
            'nama'=>'required',
            'no_hp'=>'required|numeric',
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'rt'=>'required|numeric',
            'rw'=>'required|numeric',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image|mimes:jpeg,png,jpg,jfif,gif|max:2048',
        ],[
            // 'nik.unique' => 'NIK ini sudah terdaftar. Gunakan NIK lain.',
            // 'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nama.required' => 'Nama wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rt.numeric' => 'RT harus berupa angka.',
            'rw.required' => 'RW wajib diisi.',
            'rw.numeric' => 'RW harus berupa angka.',
            'pendidikan_akhir.required' => 'Pendidikan akhir wajib diisi.',
            'status_kawin.required' => 'Status kawin wajib diisi.',
            'foto_dai.image' => 'File harus berupa gambar.',
            'foto_dai.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'foto_dai.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]); 
        if ($request->hasFile('foto_dai')) {
            if ($dai->foto_dai && Storage::disk('public')->exists($dai->foto_dai)) {
                Storage::disk('public')->delete($dai->foto_dai);
            }

            $data['foto_dai'] = $request->file('foto_dai')->store('foto_dai', 'public');
        }

        $dai->update($data);

        if ($dai->user) {
            $dai->user->update([
                'name' => $data['nama'] ?? $dai->nama,
                'image' => $data['foto_dai'] ?? $dai->foto_dai,
            ]);
        }

        return to_route('dai.index')->with('success', 'Data dai berhasil diperbarui');
    }

    public function destroy(Dai $dai)
    {
        $user = Auth::user();
        if ($user->level == 'kecamatan') {
            $allowedDesaIds = Desa::where('kecamatan_id', $user->kecamatan->id)->pluck('id');
            if (!$allowedDesaIds->contains($dai->desa_id)) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk menghapus data DAI dari desa lain.');
            }
        } 
        else {
            if ($dai->desa_id !== $user->desa->id) {
                return redirect()->route('dai.index')->with('error', 'Anda tidak memiliki akses untuk menghapus data DAI dari desa lain.');
            }
        }

        if($dai->foto_dai && Storage::disk('public')->exists($dai->foto_dai)){
            Storage::disk('public')->delete($dai->foto_dai);
        }
        if($dai->user()->exists()){
            $dai->user()->delete();
        }
        $dai->delete();
        return to_route('dai.index')->with('success','Data Dai berhasil dihapus');
    }
}

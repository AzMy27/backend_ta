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

        // Jika user adalah Kecamatan, ambil semua desa yang ada di kecamatan tersebut
        if ($user->level == 'kecamatan') {
            // Ambil desa yang terkait dengan kecamatan user
            $desaList = Desa::where('kecamatan_id', $user->kecamatan->id)->get();
        } else {
            // Jika user adalah Desa, ambil desa yang terkait dengan user tersebut
            $desaList = [$user->desa];
        }

        // Kirim $desaList ke view
        return view('dai.create', compact('desaList'));
    }


    public function store(Request $request)
    {
        $data=$request->validate([
            'nik'=>'required|unique:dais,nik',
            'nama'=>'required',
            'no_hp'=>'required',
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image',
            'desa_id' => 'exists:desas,id',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar. Gunakan NIK lain.',
            'email.unique' => 'Email ini sudah terdaftar. Gunakan email lain.',
            'password.min' => 'Password harus minimal 8 karakter.',
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
        // $dataDai = Auth::user()->desa->dai()->create($data);

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

    /**
     * Display the specified resource.
     */
    public function show(Dai $dai)
    {
        return view('dai.show',['data'=>$dai]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dai $dai)
    {
        return view('dai.edit',['data'=>$dai]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dai $dai)
    {
        $data=$request->validate([
            'nik'=>'required',
            'nama'=>'required',
            'no_hp'=>'required',
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image',
        ]); 
        if($request->hasFile('foto_dai')){
            if($dai->foto_dai && Storage::disk('public')->exists($dai->foto_dai)){
                Storage::disk('public')->delete('foto_dai')->store('foto_dai','public');
            }
            $data['foto_dai'] =  $request->file('foto_dai')->store('foto_dai','public');
        }        
        $dai->update($data);
        if ($dai->user) {
            $dai->user->update([
                'image' => $data['foto_dai'] ?? $dai->foto_dai, // sinkronkan dengan foto_dai
            ]);
        }

        return to_route('dai.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dai $dai)
    {
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

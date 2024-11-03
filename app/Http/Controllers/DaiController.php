<?php

namespace App\Http\Controllers;

use App\Models\Dai;
use Illuminate\Http\Request;

class DaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dai::get();
        return view('dai.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data=$request->validate([
            'nik'=>'required',
            'nama'=>'required',
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image',
        ]); 
        if($request->hasFile('foto_dai')){
            $data['foto_dai'] =  $request->file('foto_dai')->store('foto_dai','public');
        }

        Dai::create($data);
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
            'tanggal_lahir'=>'required|date',
            'tempat_lahir'=>'required',
            'alamat'=>'required',
            'pendidikan_akhir'=>'required',
            'status_kawin'=>'required',
            'foto_dai'=>'nullable|image',
        ]); 
        if($request->hasFile('foto_dai')){
            $data['foto_dai'] =  $request->file('foto_dai')->store('foto_dai','public');
        }        
        $dai->update($data);
        return to_route('dai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dai $dai)
    {
        $dai->delete();
        return to_route('dai.index');
    }
}

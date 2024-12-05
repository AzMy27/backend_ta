<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dai;
use Illuminate\Support\Facades\Auth; 


class ApiDaiController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        try {
            $dai = Auth::user()->dai;

            if (!$dai) {
                return response()->json(['status' => 'error', 'message' => 'Dai not found'], 404);
            }
            $data = [
                'nik' => $dai->nik,
                'nama' => $dai->nama,   
                'no_hp' => $dai->no_hp,
                'alamat' => $dai->alamat,
                'tempat_lahir' => $dai->tempat_lahir,
                'tanggal_lahir' => $dai->tanggal_lahir,
                'pendidikan_akhir' => $dai->pendidikan_akhir,
                'status_kawin' => $dai->status_kawin,
                'foto_dai' => $dai->foto_dai ? asset('storage/' . $dai->foto_dai) : null,
            ];

            return response()->json([
                'status' => 'success', 
                'data' => $data,
                ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ], 404);
        }
    }

    public function update(Request $request, string $daiId)
    {
        try{
            $dai = Auth::user()->dai;

            if (!$dai) {
                return response()->json(['status' => 'error', 'message' => 'Dai not found'], 404);
            }
            $validateData=$request->validate([
                'nik'=>'required|unique:dais,nik,{$daiId}',
                'nama'=>'required',
                'no_hp'=>'required',
                'alamat'=>'required',
                'tempat_lahir'=>'required',
                'tanggal_lahir'=>'required',
                'pendidikan_akhir'=>'required',
                'status_kawin'=>'required',
                'foto_dai'=>'nullable|image',
            ]);

            $daiData = Dai::findOrfail($dai);

            if ($request->hasFile('foto_dai')) {
                if ($daiData->foto_dai) {
                    \Storage::disk('public')->delete($daiData->foto_dai);
                }
                $validatedData['foto_dai'] = $request->file('foto_dai')->store('foto_dai', 'public');
            }
            $daiData->update($validatedData);
            return response()->json(['status' => 'success', 'message' => 'Data Dai berhasil diperbarui', 'data' => $daiData],200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ], 404);
        }
    }

    public function destroy(string $dai)
    {
        //
    }
}

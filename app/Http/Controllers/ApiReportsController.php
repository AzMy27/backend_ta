<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ApiReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        try{

        $data = $request->user()->dai->reports;
        $reports_data = [];
        foreach($data as $report) {
            $a['id'] = $report->id;
            $a['title'] = $report->title;
            $a['place'] = $report->place;
            $a['date'] = $report->date;
            $a['description'] = $report->description;
            $a['validasi_desa'] = $report->validasi_desa==null ? 'Belum divalidasi ' : $report->validasi_desa;
            $a['koreksi_desa'] = $report->koreksi_desa;
            $a['validasi_kecamatan'] = $report->validasi_kecamatan==null ? 'Belum divalidasi ' : $report->validasi_kecamatan;
            $a['koreksi_kecamatan'] = $report->koreksi_kecamatan;
            $a['images'] = [];
            foreach(json_decode($report->images,true) as $image) {
                $a['images'][]= asset('storage/'.$image);
            }
            $reports_data[] = $a;
        }        
        // $data = Report::whereDaiId($user->dai->id)->get();
        return response()->json([
            'status'=>'201',
            'message'=>'Data Laporan berhasil diambil',
            'data'=>$reports_data,
            ]);
        }catch(\Exception $e){
            \Log::error("Gagal mengambil data laporan".$e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>'Gagal mengambil data laporan',
                'error'=>[
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required|string',
            'place'=>'required|string',
            'date'=>'required|date',
            'description'=>'required|string',
            'images'=>'required',
        ]);

        try{
            foreach($request->file('images') as $images){
                    $path[]=$images->store('laporan','public');
            }
            $validateData['images']= json_encode($path);

                //create report dari auth user api lalu relasi dai dan report dai
            $reportAPI = $request->user()->dai->reports()->create($validateData);

            return response()->json([
                'status'=>'success',
                'message'=>'Laporan Berhasil Dibuat',
                'data'=>$reportAPI
            ],201);
        }catch(\Exception $e){
            foreach ($path as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            \Log::error("Failed to create report: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create report',
                'error' => $e->getMessage(),
            ], 500);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        $a['date'] = $report->date;
        $a['description'] = $report->description;
        $a['validasi_desa'] = $report->validasi_desa==null ? 'Belum divalidasi ' : $report->validasi_desa;
        $a['validasi_kecamatan'] = $report->validasi_kecamatan==null ? 'Belum divalidasi ' : $report->validasi_kecamatan;
        $a['koreksi_kecamatan'] = $report->koreksi_kecamatan;
        $a['koreksi_desa'] = $report->koreksi_desa;
        $a['images'] = [];
        foreach(json_decode($report->images,true) as $image) {
            $a['images'][]= asset('storage/'.$image);
        }
        return response()->json(['status'=>'201','data'=>$a]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
           
       $validateData = $request->validate([
        'title'=>'required|string',
        'place'=>'required|string',
        'date'=>'required|date',
        'description'=>'required|string',
       ]);
       $reportAPI = $report->update($validateData);

       return response()->json(['status'=>'201','message'=>'Berhasil edit report']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

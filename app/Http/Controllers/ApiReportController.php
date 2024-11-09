<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;


class ApiReportController extends Controller
{
    public function index()
    {
        $reportAPI = Report::get();
        return response()->json($reportAPI);
    }


    public function store(Request $request)
    {
        $validateData =$request->validate([
            'title'=>'required',
            'place'=>'required',
            'date'=>'required|date',
            'description'=>'required',
            'images'=>'required|array',
        ]); 

        foreach($request->file('images') as $images) {
            $path[] = $images->store('laporan','public'); 
        }
            $validateData['images'] = json_encode($path); 

        // if($request->hasFile('images')){
        //     $validateData['images'] = $request->file('images')->store('laporan','public');
        // }

        $reportAPI = Report::create($validateData);
        return response()->json($reportAPI,201);
    }

    public function show(string $id)
    {
        $reportAPI = Report::findOrFail($id);
        return response()->json($reportAPI);
    }

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'title'=>'required',
            'place'=>'required',
            'date'=>'required',
            'description'=>'required',
            'images'=>'required|array',
            ]);

            $reportAPI = Report::findOrFail($id);
            $reportAPI->update($validateData);
            if($request->hasFile('images')){
                $path = [];
                foreach($request->file('images') as $images) {
                    $path[] = $images->store('laporan','public');
                }
                $reportAPI->update(['images' => json_encode($path)]);
            }
            return response()->json($reportAPI,200);
    }

    public function destroy(string $id)
    {
        $reportAPI = Report::findOrFail($id);
        
        if($reportAPI->images){
            Storage::delete('public'.$reportAPI->images);
        }

        // if($report->images && Storage::disk('public')->exists($dai->foto_dai)){
        //     Storage::disk('public')->delete($dai->foto_dai);
        // }        

        $reportAPI->delete();
        return response()->json(['message'=>'Laporan Berhasil Dihapus'],204);
    }
}

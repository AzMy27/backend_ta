<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;


class ApiReportController extends Controller
{
    public function index()
    {
        $report = Report::get();
        return response()->json($report);
    }


    public function store(Request $request)
    {
        $validatedData =$request->validate([
            'title'=>'required',
            'place'=>'required',
            'date'=>'required|date',
            'description'=>'required',
            'images'=>'required|array',
        ]); 

        foreach($request->file('images') as $images) {
            $path[] = $images->store('laporan','public'); 
        }
            $validatedData['images'] = json_encode($path); 

        // if($request->hasFile('images')){
        //     $validatedData['images'] = $request->file('images')->store('laporan','public');
        // }

        $report = Report::create($validatedData);
        return response()->json($report,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        return response()->json($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);
        
        if($report->images){
            Storage::delete('public'.$report->images);
        }

        // if($report->images && Storage::disk('public')->exists($dai->foto_dai)){
        //     Storage::disk('public')->delete($dai->foto_dai);
        // }        

        $report->delete();
        return response()->json(['message'=>'Laporan Berhasil Dihapus'],204);
    }
}

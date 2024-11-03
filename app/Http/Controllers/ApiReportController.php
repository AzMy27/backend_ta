<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        // return view('reports.index', compact('reports'));
    }

    public function create(){
        // return view('reports/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'place'=>'required',
            'date'=>'required|date',
            'description'=>'required',
            'images'=>'nullable|image',
        ]); 

        if($request->hasFile('images')){
            $imagePath = $request->file('images')->store('images','public');
        }

        $report = Report::create([
            'title'=>request->title,
            'place'=>request->place,
            'date'=>request->date,
            'description'=>request->description,
            'images'=>isset($imagePath)?$imagePath:null
        ]);
        return response->json($report,201);
        // return redirect()->route('reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Report::findOrFail($id);
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
        Report::destroy($id);
        return response()->json($report,204);
    }
}

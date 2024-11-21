<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        // return view('reports.index');
        $reports = Report::get();
        return view('reports.index',['reports'=>$reports]);        
    }

    public function show(string $id)
    {
        return view('reports.show',['reports'=>$id]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id->delete();
        return to_route('reports.index');
    }
}

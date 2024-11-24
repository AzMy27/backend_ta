<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use PDF;


class ReportController extends Controller
{
    public function index()
    {
        $user =Auth::user();
        if($user->isDesa()){
            $reports = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            })->get();
        }else{
            
        $reports = Report::get();
        }
        // return view('reports.index');
        return view('reports.index',['reports'=>$reports]);        
    }

    public function show(string $id)
    {
        $reports = Report::findOrFail($id);
        return view('reports.show',['reports'=>$reports]);
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

    public function downloadPDF(string $id)
    {
        $report = Report::findOrFail($id);
        
        $pdf = PDF::loadView('reports.pdf', [
            'report' => $report,
            'images' => json_decode($report->images, true)
        ]);
        
        return $pdf->download('laporan-'.$report->dai->nama.'.pdf');
    }
}

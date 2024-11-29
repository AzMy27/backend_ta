<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use PDF;


class ReportController extends Controller
{
    public function index(){
        $user =Auth::user();
        if($user->isDesa()){
            $reports = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            })->get();
        }else{
            
        $reports = Report::get();
        }
        return view('reports.index',['reports'=>$reports]);        
    }

    public function show(string $id){
        $reports = Report::findOrFail($id);
        return view('reports.show',[
            'reports'=>$reports,
            'canValidateKecamatan' => $this->kecamatanCanValidate($reports)
        ]);
    }


    public function edit(string $id){
        //
    }


    public function update(Request $request, string $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        // $id->delete();
        // return to_route('reports.index');
    }

    public function downloadPDF(string $id){
        $report = Report::findOrFail($id);
        
        $pdf = PDF::loadView('reports.pdf', [
            'report' => $report,
            'images' => json_decode($report->images, true)
        ]);
        
        return $pdf->download('laporan - '.$report->dai->nama.'.pdf');
    }

    public function desaApprove(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);
        if($user->isDesa() && $user->desa->id == $report->dai->desa_id){
            $report->validasi_desa = 'diterima';
            $report->save();
            return redirect()->route('reports.index')->with('success', 'Laporan berhasil diterima.');
        }

        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang untuk aksi ini.');

    }

    // Desa
    public function desaReject(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);
        if($user->isDesa() && $user->desa->id == $report->dai->desa_id){
            $report->validasi_desa = 'ditolak';
            $report->save();
            return redirect()->route('reports.desa.comment.get', $report->id);
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang');
    }

    public function kecamatanCanValidate(Report $report){
        return $report->validasi_desa === 'diterima';
    }

    // Kecamatan 
    public function kecamatanApprove(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);

        if(!$this->kecamatanCanValidate($report)){
            return redirect()->route('reports.index')->with('error','Laporan belum diterima oleh desa');
        }

        if($user->isKecamatan() && $user->kecamatan->id == $report->dai->desa->kecamatan_id){
            $report->validasi_kecamatan = 'diterima';
            $report->save();
            return redirect()->route('reports.index')->with('success','Laporan berhasil diterima');
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang untuk aksi ini.');
    }

    public function kecamatanReject(Request $request,$id){
        $user = Auth::user();
        $report = Report::findOrFail($id);

        if(!$this->kecamatanCanValidate($report)){
            return redirect()->route('reports.index')->with('error','Laporan belum diterima oleh desa');
        }

        if($user->isKecamatan() && $user->kecamatan->id == $report->dai->desa->kecamatan_id){
            $report->validasi_kecamatan = 'ditolak';
            $report->save();
            return redirect()->route('reports.kecamatan.comment.get', $report->id);
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang');
    }

    public function desaCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.desa-reject', compact('report'));
    }

    public function desaCommentPost(Request $request, $id){
        $request->validate([
            'comment'=>'required|string'
        ]);
        $report = Report::findOrFail($id);
        $report->koreksi_desa = $request->comment;
        $report->save();

        return redirect()->route('reports.index')->with('success','Pesan perbaikan berhasil disimpan');
    }

    public function kecamatanCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.kecamatan-reject', compact('report'));
    }

    public function kecamatanCommentPost(Request $request, $id){
        $request->validate([
            'comment' => 'required|string',
        ]);
        $report = Report::findOrFail($id);
        $report->koreksi_kecamatan = $request->comment;
        $report->save();
        return redirect()->route('reports.index')->with('success','Pesan perbaikan berhasil disimpan');
    }
}

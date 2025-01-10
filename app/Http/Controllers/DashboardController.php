<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Dai;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kecamatanName = null;

        if (Auth::user()->isSuper()) {
            $data['jumlah_report'] = Report::count();
            $data['jumlah_report_diterima'] = Report::whereValidasiKecamatan('diterima')->count();
            $data['jumlah_kecamatan'] = Kecamatan::count();
            $data['jumlah_desa'] = Desa::count();
            $data['jumlah_dai'] = Dai::count();
        } elseif (Auth::user()->isKecamatan()) {
            $data['jumlah_desa'] = Desa::where('kecamatan_id', Auth::user()->kecamatan->id)->count();
            $data['jumlah_dai'] = Dai::whereHas('desa',function($q){
                $q->where('kecamatan_id',Auth::user()->kecamatan->id);
            })->count();

            $data['jumlah_report'] = Report::whereHas('dai', function ($q){
                $q->whereHas('desa.kecamatan',function($q){
                    $q->whereId(Auth::user()->kecamatan->id);
                });
            })->count();
            $data['jumlah_report_diterima'] = Report::whereHas('dai', function ($q){
                $q->whereHas('desa.kecamatan',function($q){
                    $q->whereId(Auth::user()->kecamatan->id);
                });
            })->whereValidasiKecamatan('diterima')->count();
        } elseif (Auth::user()->isDesa()) {
            $data['jumlah_dai'] = Dai::where('desa_id', Auth::user()->desa->id)->count();
            $data['jumlah_report'] = Report::whereHas('dai', function ($q){
                $q->whereDesaId(Auth::user()->desa->id);
            })->count();
            $data['jumlah_report_diterima'] = Report::whereHas('dai', function ($q){
                $q->whereDesaId(Auth::user()->desa->id);
            })->whereValidasiDesa('diterima')->count();
        }
        // return $data;
        if($user->isKecamatan()){
            $kecamatanName = $user->kecamatan->nama_kecamatan;
        }
        
        if($user->isDesa()){
            $reports = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            })->get();
        }elseif($user->isKecamatan()){
            $reports = Report::withWhereHas('dai.desa', function($query) use($user){
                $query->where('kecamatan_id', $user->kecamatan->id);
            })->get();            
        }else{
            $reports = Report::get();
        }

        return view('dashboard.index',array_merge([
            'reports' => $reports,
        ],$data));
    }


}
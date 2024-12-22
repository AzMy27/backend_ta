<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $monthlyReports = $this->getMonthlyReports($user);
        $kecamatanName = null;
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

        return view('dashboard.admin',[
            'reports' => $reports,
            'monthlyReports' => $monthlyReports,
            'kecamatanName'=>$kecamatanName
        ]);
    }

    private function getMonthlyReports($user)
    {
        $query = Report::query()
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT dai_id) as total_dai')
            );
        if($user->isDesa()){
            $query->whereHas('dai', function($q) use($user){
                $q->where('desa_id', $user->desa->id);
            });
        }elseif($user->isKecamatan()){
            $query->whereHas('dai.desa', function($q) use($user){
                $q->where('kecamatan_id', $user->kecamatan->id);
            });
        }

        return $query->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($item) {
                $item->month_name = Carbon::create(2000, $item->month, 1)->format('F');
                return $item;
            });
    }
}
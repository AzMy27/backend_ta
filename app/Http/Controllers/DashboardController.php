<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Dai;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedYear = $request->input('year', Carbon::now()->year);
        
        // Get available years for dropdown
        if($user->isDesa()){
            $years = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            })->selectRaw('YEAR(date) as year')
              ->distinct()
              ->pluck('year')
              ->sort()
              ->values();
        }elseif($user->isKecamatan()){
            $years = Report::withWhereHas('dai.desa', function($query) use($user){
                $query->where('kecamatan_id', $user->kecamatan->id);
            })->selectRaw('YEAR(date) as year')
              ->distinct()
              ->pluck('year')
              ->sort()
              ->values();
        }else{
            $years = Report::selectRaw('YEAR(date) as year')
                          ->distinct()
                          ->pluck('year')
                          ->sort()
                          ->values();
        }

        if($years->isEmpty()) {
            $years = collect([Carbon::now()->year]);
        }

        // Dashboard statistics
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

        // Monthly report query (filtered by year)
        if($user->isDesa()){
            $monthlyQuery = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            });
        }elseif($user->isKecamatan()){
            $monthlyQuery = Report::withWhereHas('dai.desa', function($query) use($user){
                $query->where('kecamatan_id', $user->kecamatan->id);
            });            
        }else{
            $monthlyQuery = Report::query();
        }

        $monthlyQuery->whereYear('date', $selectedYear);

        // Daily report query (always last 7 days)
        if($user->isDesa()){
            $dailyQuery = Report::withWhereHas('dai', function($query)use($user){
                $query->where('desa_id', $user->desa->id);
            });
        }elseif($user->isKecamatan()){
            $dailyQuery = Report::withWhereHas('dai.desa', function($query) use($user){
                $query->where('kecamatan_id', $user->kecamatan->id);
            });            
        }else{
            $dailyQuery = Report::query();
        }

        // Process monthly data
        $monthlyData = $monthlyQuery->get()->groupBy(function($date) {
            return Carbon::parse($date->date)->format('n');
        })->map->count();

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $chartData = [];
        $chartLabels = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $monthNames[$i];
            $chartData[] = $monthlyData[$i] ?? 0;
        }

        // Process daily data (always last 7 days)
        $dailyData = $dailyQuery->whereDate('date', '>=', Carbon::now()->subDays(6))
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->date)->format('j');
            })
            ->map->count();

        $dailyLabels = [];
        $dailyValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->format('j');
            $dailyValues[] = $dailyData[$date->format('j')] ?? 0;
        }

        // Get reports for table display (filtered by year)
        $reports = $monthlyQuery->get();

        if ($user->isKecamatan()) {
            $nama_kecamatan = $user->kecamatan->nama_kecamatan;
        } elseif ($user->isDesa()) {
            $nama_kecamatan = $user->desa->kecamatan->nama_kecamatan;
        } else {
            $nama_kecamatan = "Semua Kecamatan";
        }

        return view('dashboard.index', array_merge([
            'reports' => $reports,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'dailyLabels' => $dailyLabels,
            'dailyValues' => $dailyValues,
            'years' => $years,
            'selectedYear' => $selectedYear,
            'nama_kecamatan' => $nama_kecamatan,
        ], $data));
    }
}
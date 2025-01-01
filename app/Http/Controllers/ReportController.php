<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(){
        $user =Auth::user();
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
        return view('reports.index',['reports'=>$reports]);        
    }

    public function show(string $id){
        $user = Auth::user();
        $reports = Report::findOrFail($id);

        if ($user->isDesa()) {
            if ($reports->dai->desa_id !== $user->desa->id) {
                return redirect()->route('reports.index')->with('error', 'Anda tidak memiliki akses untuk melihat laporan dari desa lain.');
            }
        }

        if ($user->isKecamatan()) {
            if ($reports->dai->desa->kecamatan_id !== $user->kecamatan->id) {
                return redirect()->route('reports.index')->with('error', 'Anda tidak memiliki akses untuk melihat laporan dari kecamatan lain.');
            }
        }
        return view('reports.show',[
            'reports'=>$reports,
            'canValidateKecamatan' => $this->kecamatanCanValidate($reports)
        ]);
    }

    private function sendDaiNotification($report, $status, $level, $comment = null){
        $dai = User::find($report->dai->user_id);
        if ($dai && $dai->token_firebase) {
            $title = "Laporan $status oleh $level";
            $body = $comment ? "Alasan: $comment" : "Laporan anda telah $status";
            $data = [
                'title' => $title,
                'body' => $body,
                'report_id' => $report->id
            ];
            $this->sendFCM($dai->token_firebase, $data);
        }
    }

    private function sendFCM($token, $data) {
        try {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $serverKey = config('services.firebase.server_key');
            $fields = [
                'to' => $token,
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['body']
                ],
                'data' => [
                    ...$data,
                    'route' => '/notification_screen'
                ]
            ];

            $headers = [
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json'
            ];

            \Log::info('FCM Payload: ' . json_encode($fields));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            \Log::info('FCM Response Code: ' . $httpCode);
            \Log::info('FCM Response: ' . $response);

            curl_close($ch);
            if ($httpCode !== 200) {
                \Log::error('FCM Notification failed: ' . $response);
                \Log::error('HTTP Code: ' . $httpCode);
                \Log::error('Token: ' . $token);
                \Log::error('Data: ' . json_encode($data));
            }
        } catch (\Exception $e) {
            \Log::error('FCM Sending Exception: ' . $e->getMessage());
        }
    }
    // Desa
    public function desaApprove(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);
        if($user->isDesa() && $user->desa->id == $report->dai->desa_id){
            return redirect()->route('reports.desa.approve.comment.get', $report->id);
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang untuk aksi ini.');
    }

    public function desaReject(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);
        if($user->isDesa() && $user->desa->id == $report->dai->desa_id){
            return redirect()->route('reports.desa.comment.get', $report->id);
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang');
    }
    // Komentar desa
    public function desaApproveCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.desa-approve', compact('report'));
    }

    public function desaApproveCommentPost(Request $request, $id){
        $request->validate([
            'comment'=>'required|string'
        ],[
            'comment.required'=> 'Komentar harus diisi'
        ]);
        $report = Report::findOrFail($id);
        $report->validasi_desa = 'diterima';
        $report->koreksi_desa = $request->comment;
        $report->save();
        $this->sendDaiNotification($report, 'diterima', 'Desa', $request->comment);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diterima dan komentar disimpan.');
    }

    public function desaRejectCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.desa-reject', compact('report'));
    }

    public function desaRejectCommentPost(Request $request, $id){
        $request->validate([
            'comment'=>'required|string'
        ],[
            'comment.required'=> 'Komentar harus diisi'
        ]);
        $report = Report::findOrFail($id);
        $report->validasi_desa = 'ditolak';
        $report->koreksi_desa = $request->comment;
        $report->save();
        $this->sendDaiNotification($report, 'ditolak','Desa',$request->comment);
        return redirect()->route('reports.index')->with('success','Pesan perbaikan berhasil disimpan');
    }    
    // Kecamatan
    public function kecamatanCanValidate(Report $report){
        return $report->validasi_desa === 'diterima';
    }

    public function kecamatanApprove(Request $request, $id){
        $user = Auth::user();
        $report = Report::findOrFail($id);

        if(!$this->kecamatanCanValidate($report)){
            return redirect()->route('reports.index')->with('error','Laporan belum diterima oleh desa');
        }

        if($user->isKecamatan() && $user->kecamatan->id == $report->dai->desa->kecamatan_id){
            return redirect()->route('reports.kecamatan.approve.comment.get', $report->id);
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
            return redirect()->route('reports.kecamatan.comment.get', $report->id);
        }
        return redirect()->route('reports.index')->with('error', 'Anda tidak berwenang untuk aksi ini');
    }
    // Komentar kecamata
    public function kecamatanApproveCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.kecamatan-approve', compact('report'));
    }

    public function kecamatanApproveCommentPost(Request $request, $id){
        $request->validate([
            'comment'=>'required|string'
        ],[
            'comment.required'=> 'Komentar harus diisi'
        ]);
        $report = Report::findOrFail($id);
        $report->validasi_kecamatan = 'diterima';
        $report->koreksi_kecamatan = $request->comment;
        $report->save();
        $this->sendDaiNotification($report, 'diterima', 'Kecamatan', $request->comment);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diterima dan komentar disimpan.');
    }

    public function kecamatanRejectCommentGet($id){
        $report = Report::findOrFail($id);
        return view('reports.kecamatan-reject', compact('report'));
    }

    public function kecamatanRejectCommentPost(Request $request, $id){
        $request->validate([
            'comment' => 'required|string',
        ],[
            'comment.required'=> 'Alasan harus diisi'
        ]);
        $report = Report::findOrFail($id);
        $report->validasi_kecamatan = 'ditolak';
        $report->koreksi_kecamatan = $request->comment;
        $report->save();
        $this->sendDaiNotification($report, 'ditolak','Desa',$request->comment);
        return redirect()->route('reports.index')->with('success','Pesan perbaikan berhasil disimpan');
    }

    public function monthRecapPDF(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date');
        
        if ($date) {
            $date = Carbon::createFromFormat('Y-m', $date);
        } else {
            $date = now();
        }

        $startOfMonth = Carbon::parse($date)->startOfMonth();
        $endOfMonth = Carbon::parse($date)->endOfMonth();

        $query = Report::whereBetween('date', [
            $startOfMonth->format('Y-m-d'),
            $endOfMonth->format('Y-m-d'),
        ]);

        if($user->isDesa()){
            $query = $query->whereHas('dai', function($q) use($user){
                $q->where('desa_id', $user->desa->id);
            });
        }elseif($user->isKecamatan()){
            $query = $query->whereHas('dai.desa', function($q) use($user){
                $q->where('kecamatan_id', $user->kecamatan->id);
            });        
        }

        $reports = $query->with(['dai', 'dai.desa'])->orderBy('date', 'asc')->get();

        if ($reports->isEmpty()) {
            return redirect()->route('reports.index')
                ->with('error', 'Tidak ada laporan untuk bulan ' . 
                    $startOfMonth->isoFormat('MMMM Y'));
        }

        $groupedReports = $reports->groupBy('dai.id');
        
        $pdf = PDF::loadView('reports.month', [
            'groupedReports' => $groupedReports,
            'startDate' => $startOfMonth,
            'endDate' => $endOfMonth,
            'user' => $user
        ])->setPaper('a4', 'landscape');
        
        return $pdf->download('rekap-bulanan-'.$startOfMonth->format('Y-m-d').'.pdf');
    }
}

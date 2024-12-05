<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ApiReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        try{
            $data = $request->user()->dai->reports;
            $reports_data = [];
            foreach($data as $report) {
                $a['id'] = $report->id;
                $a['title'] = $report->title;
                $a['place'] = $report->place;
                $a['date'] = $report->date;
                $a['description'] = $report->description ?? '';
                $a['coordinate_point'] = $report->coordinate_point ?? '';
                $a['validasi_desa'] = $report->validasi_desa==null ? 'Belum divalidasi ' : $report->validasi_desa;
                $a['koreksi_desa'] = $report->koreksi_desa ?? '';
                $a['validasi_kecamatan'] = $report->validasi_kecamatan==null ? 'Belum divalidasi ' : $report->validasi_kecamatan;
                $a['koreksi_kecamatan'] = $report->koreksi_kecamatan ?? '';
                $a['images'] = [];
                foreach(json_decode($report->images,true) as $image) {
                    $a['images'][]= asset('storage/'.$image);
                }
                $reports_data[] = $a;
            }        
        // $data = Report::whereDaiId($user->dai->id)->get();
        return response()->json([
            'status'=>'201',
            'message'=>'Data Laporan berhasil diambil',
            'data'=>$reports_data,
            ]);
        }catch(\Exception $e){
            \Log::error("Gagal mengambil data laporan".$e->getMessage());
            return response()->json([
                'status'=>'error',
                'message'=>'Gagal mengambil data laporan',
                'error'=>[
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg',
            'coordinate_point' => 'required|string',
        ]);

        try {
            $paths = []; 
            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = uniqid('report_') . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('laporan', $filename, 'public');
                    if ($path) {
                        $paths[] = $path;
                    } else {
                        throw new \Exception('Failed to store image');
                    }
                }
            }
            if (empty($paths)) {
                throw new \Exception('No images were uploaded');
            }

            $reportData = [
                'title' => $validateData['title'],
                'place' => $validateData['place'],
                'date' => $validateData['date'],
                'description' => $validateData['description'],
                'images' => json_encode($paths),
                'coordinate_point' => $validateData['coordinate_point'],
            ];
            $report = $request->user()->dai->reports()->create($reportData);

            return response()->json([
                'status' => 'success',
                'message' => 'Laporan Berhasil Dibuat',
                'data' => $report
            ], 201);

        } catch (\Exception $e) {
            if (!empty($paths)) {
                foreach ($paths as $filePath) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            \Log::error("Failed to create report: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        try{
            $a['title'] = $report->title;
            $a['place'] = $report->place;
            $a['date'] = $report->date;
            $a['description'] = $report->description;
            $a['coordinate_point'] = $report->coordinate_point ?? '';
            $a['validasi_desa'] = $report->validasi_desa==null ? 'Belum divalidasi ' : $report->validasi_desa;
            $a['validasi_kecamatan'] = $report->validasi_kecamatan==null ? 'Belum divalidasi ' : $report->validasi_kecamatan;
            $a['koreksi_desa'] = $report->koreksi_desa == null ? 'Belum dikoreksi' : $report->koreksi_desa;
            $a['koreksi_kecamatan'] = $report->koreksi_kecamatan == null ? 'Belum dikoreksi' : $report->koreksi_kecamatan;
            $a['images'] = [];
            foreach(json_decode($report->images,true) as $image) {
                $a['images'][]= asset('storage/'.$image);
            }
            return response()->json(['status'=>'success','data'=>$a]);
        }catch(\Exception $e){
            \Log::error('Gagal mengambil data laporan: '.$e->getMessage());
            return response()->json([
                'status'=> 'error',
                'message'=>'Gagal mengambil data laporan',
                'error'=>[
                    'message'=>$e->getMessage(),
                    'code'=>$e->getCode(),
                ],
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        if ($request->user()->dai->id !== $report->dai_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengubah laporan ini'
            ], 403);
        }

        if ($report->validasi_desa !== 'ditolak' && $report->validasi_kecamatan !== 'ditolak') {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan ini tidak dapat diubah'
            ], 400);
        }

        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg',
            'coordinate_point' => 'required|string',
        ]);

        try {
            $paths = $report->images ? json_decode($report->images, true) : [];
            
            if ($request->hasFile('images')) {
                foreach ($paths as $oldPath) {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $paths = [];
                foreach ($request->file('images') as $image) {
                    $filename = uniqid('report_') . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('laporan', $filename, 'public');
                    $paths[] = $path;
                }
            }

            $reportData = [
                'title' => $validateData['title'],
                'place' => $validateData['place'],
                'date' => $validateData['date'],
                'description' => $validateData['description'],
                'coordinate_point' => $validateData['coordinate_point'],
                'images' => json_encode($paths),
                
                'validasi_desa' => null,
                'koreksi_desa' => null,
                'validasi_kecamatan' => null,
                'koreksi_kecamatan' => null,
            ];

            $report->update($reportData);

            return response()->json([
                'status' => 'success',
                'message' => 'Laporan berhasil diperbarui dan siap diajukan ulang',
                'data' => $report
            ], 200);

        } catch (\Exception $e) {
            if (!empty($paths)) {
                foreach ($paths as $filePath) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            \Log::error("Failed to update report: " . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // function sendFirebaseNotification($token, $title, $body, $data = []) {
    //     // URL Firebase Cloud Messaging API
    //     $url = "https://fcm.googleapis.com/fcm/send";

    //     $serverKey = "BDfuHde8NhDHnaE-X2sAgYQPSEf0xBe4M2RYIEwA-C-ZjbNnLDIF9YnLIgadv-MsxR942MLKI9KpP1YMvmZFfOM";

    //     // Data notifikasi
    //     $notification = [
    //         'title' => $title,
    //         'body' => $body,
    //         'sound' => 'default'
    //     ];

    //     // Payload yang akan dikirim
    //     $payload = [
    //         'to' => $token, // Token perangkat
    //         'notification' => $notification,
    //         'data' => $data // Data tambahan (opsional)
    //     ];

    //     // Konversi payload ke JSON
    //     $jsonPayload = json_encode($payload);

    //     // Inisialisasi cURL
    //     $ch = curl_init();

    //     // Konfigurasi cURL
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Authorization: key=$serverKey",
    //         "Content-Type: application/json"
    //     ]);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

    //     // Eksekusi cURL
    //     $response = curl_exec($ch);

    //     // Tangani error cURL
    //     if ($response === FALSE) {
    //         die('Curl failed: ' . curl_error($ch));
    //     }

    //     // Tutup cURL
    //     curl_close($ch);

    //     // Kembalikan respons
    //     return $response;
    // }

    // // Token perangkat tujuan (didapat dari aplikasi)
    // $deviceToken = "DEVICE_TOKEN_HERE";

    // // Kirim notifikasi
    // $response = sendFirebaseNotification(
    //     $deviceToken,
    //     "Judul Notifikasi",
    //     "Isi pesan notifikasi",
    //     ["key1" => "value1", "key2" => "value2"] // Data tambahan (opsional)
    // );

    // // Tampilkan respons dari Firebase
    // echo $response;

}

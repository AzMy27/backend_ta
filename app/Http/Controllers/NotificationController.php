<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private function sendDaiNotification($report, $status, $level, $comment = null){
        $dai = User::find($report->dai->user_id);
        if ($dai && $dai->token_firebase) {
            $title = "Laporan $status oleh $level";
            $body = $comment ? "Alasan: $comment" : "Laporan anda telah $status";
            $data = [
                'title' => $title,
                'body' => $body,
                'report_id' => $report->id,
                'status' => $status,
                'level' => $level,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
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
}

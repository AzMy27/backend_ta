<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFCMNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;
    protected $data;

    public function __construct($token, $data)
    {
        $this->token = $token;
        $this->data = $data;
    }

    public function handle()
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = config('services.firebase.server_key');

        $fields = [
            'to' => $this->token,
            'notification' => [
                'title' => $this->data['title'],
                'body' => $this->data['body'],
            ],
            'data' => $this->data,
        ];

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $response = curl_exec($ch);
        curl_close($ch);
    }
}

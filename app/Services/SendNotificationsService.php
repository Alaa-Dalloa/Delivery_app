<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SendNotificationsService
{
    public function sendByFcm(string $fcm, array $message)
    {
        $apiUrl = 'https://fcm.googleapis.com/v1/projects/deliveryapp-16e35/messages:send';
        $access_token = Cache::remember('access_token', now()->addHour(), function () use ($apiUrl) {
            $credentialsFilePath = storage_path('app/fcm.json');
            $client = new \Google_Client();
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();
            $token = $client->getAccessToken();

            return $token['access_token'];
        });
      

        $message = [
            "message" => [
                "token" =>$fcm,
                "notification" => $message,
            ]
        ];

        $response = Http::withHeaders(['Authorization'=> "Bearer $access_token"])->post($apiUrl, $message);
        
    }
}

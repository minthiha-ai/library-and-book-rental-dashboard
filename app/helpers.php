<?php

use App\Models\FcmTokenKey;
use Illuminate\Support\Facades\Http;

function sendPushNotification($title, $message, $userId)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    // $serverKey = config('app.firebase.server_key');
    $serverKey = "AAAAWaaiLHQ:APA91bH6LtYVzj1wb_N646mRCX3e2pwdC5DVmbOowhICCSLF6oqXpo3HKMORjha0raGs4yqx28I1rhOr4hNulyWaQPTKkstJHZm5U1bZKXybtqhO43-A6QlO4D9OgFWwJu1UJnTe4Xk-";
    $fcm_user_keys = FcmTokenKey::where('user_id', $userId)->get();
    // return $fcm_user_keys;
    $notificaions = [
        'title' => $title,
        'body' => $message,
    ];
    foreach ($fcm_user_keys as $item) {
        // echo $item->fcm_token_key.'<br>';
        Http::withHeaders([
            'Authorization' => "key={$serverKey}",
            'Content-Type' => "application/json"
        ])->post($url, [
            'to' => $item->fcm_token_key,
            'notification' => $notificaions,
        ]);

    }


    return true;
}

    // public function sendNotification(Request $request)
    // {
    //     $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

    //     $SERVER_API_KEY = 'AAAAC_xrhIE:APA91bEmITX1qxTRNWTf5Xa0cmsprMo5elQZ9IwzLVxXxEYpIH4SM8TzDgVGlIbkQI4mCUg_b1jTB9JwQP-K9kBmMrLGvDJrceAafl4xZIMIBVFbYSOuqgvuCobuvpbGMH9Z8hrzUAuw';

    //     $data = [
    //         "registration_ids" => $firebaseToken,
    //         "notification" => [
    //             "title" => $request->title,
    //             "body" => $request->body,
    //             "content_available" => true,
    //             "priority" => "high",
    //         ]
    //     ];
    //     $dataString = json_encode($data);

    //     $headers = [
    //         'Authorization: key=' . $SERVER_API_KEY,
    //         'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //     $response = curl_exec($ch);

    //     dd($response);
    // }

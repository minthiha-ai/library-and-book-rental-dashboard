<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function test()
    {
        $otp = rand(1000, 9999);
        $token = 'z_-ofYj_-BjFTCLsU_cVB3lWE782gzbZtbjFy9ESBFlTca4AEqmg6WYdUgJ3Rols';
        $payload = [
            'to'      => '09958603192',
            'message' => 'Wisdom Tree Library : Your OTP code is - '.$otp,
            'sender'  => 'Wisdom Tree Library',
        ];
        // $payload = [
        //     'to'      => '09799950611',
        //     'message' => 'Pyit Tine Htaung App : your code is ' . $otp,
        //     'sender'  => 'PTH O2O',
        //   ];

        // Send the HTTP POST request and capture the response
        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://smspoh.com/api/v2/send', $payload);

        // Check if the response was successful (status code 200)
        if ($response->successful()) {
            // Return the response content as a JSON object
            return $response->json();
        } else {
            // Return an error message or handle the error as needed
            return response()->json(['error' => 'SMS sending failed'], 500);
        }
    }
}

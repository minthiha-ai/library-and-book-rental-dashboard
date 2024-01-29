<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillables = ['user_id','otp','expried_at'];

    public function sendSMS($recieveNumber)
    {
        $token = 'z_-ofYj_-BjFTCLsU_cVB3lWE782gzbZtbjFy9ESBFlTca4AEqmg6WYdUgJ3Rols';
        $payload = [
            'to' => $recieveNumber,
            'message' => 'Wisdom Tree Library : Your OTP code is - '.$this->otp,
            'sender' => 'Wisdom Tree Library',
        ];

        $response = Http::withToken($token)
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post('https://smspoh.com/api/v2/send', $payload);

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;

class AuthOtpController extends Controller
{

    public function generate(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);
    }

    private function generateOtp($phone) {
        $user = User::where('phone', $phone)->first();

        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();

        $now = now();

        if ($userOtp && $now->isBefore($userOtp->expire_at)) {
            return $userOtp;
        }

        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(1000, 9999),
            'expired_at' => $now->addMinutes(5),
        ]);
    }

    private function loginWihtOtp(Request $request) {
        $request->validate([
            // ''
        ]);
    }
}

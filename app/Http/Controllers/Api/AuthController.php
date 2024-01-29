<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\FcmTokenKey;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Controllers\Api\BaseController;

class AuthController extends BaseController
{
    //login
    public function login(LoginRequest $request)
    {
        if (Auth::guard('api')->user()) {
            return $this->sendError(401, 'Already login!');
        }

        $customer = User::withCount('fcmTokenKey')->orWhere('email', $request->emailOrPhone)->orWhere('phone', $request->emailOrPhone)->first();
        if ($customer->fcm_token_key_count >= 5) {
            $firstFcmTokenKey = FcmTokenKey::where('user_id', $customer->id)->first();
            $firstFcmTokenKey->update(['fcm_token_key' => $request->fcm_token_key]);
        } else {
            FcmTokenKey::create([
                'user_id' => $customer->id,
                'fcm_token_key' => $request->fcm_token_key,
            ]);
        }

        $hashPassword = $customer->password;
        if (Hash::check($request->password, $hashPassword)) {
            return response()->json([
                'success' => true,
                'token' => $customer->createToken(config('app.companyInfo.name'))->accessToken,
                'data' => new UserResource($customer),
            ], 200);
        } else {
            return $this->sendError(401, 'Credentials do not match');
        }


    }

    public function register(RegisterRequest $request)
    {
        if (Auth::guard('api')->check()) {
            return $this->sendError(401, 'Already logged in!');
        }

        $customer = new User();
        $customer->name = $request->input('name');
        $customer->password = Hash::make($request->input('password'));
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->user_code = uniqid('wisdom_tree'); // Generate unique user code
        $customer->save();

        FcmTokenKey::create([
            'user_id' => $customer->id,
            'fcm_token_key' => $request->input('fcm_token_key'),
        ]);

        if ($customer) {
            return response()->json([
                'success' => true,
                'token' => $customer->createToken('MYAPP')->accessToken,
                'data' => new UserResource($customer),
            ], 200);
        }

        return $this->sendError(401, 'Registration failed! Please try again.');
    }


    //logout
    public function logout()
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->sendError(401, 'User not authenticated');
        }

        $user->token()->revoke();
        return $this->sendResponse('Logout successfully');
    }

    private function getCustomerRequestData($request)
    {
        $data = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            'user_code' => 'asdasd',
        ];
        if ($request->email) {
            $data['email'] = $request->email;
        }
        if ($request->phone) {
            $data['phone'] = $request->phone;
        }

        return $data;
    }
}

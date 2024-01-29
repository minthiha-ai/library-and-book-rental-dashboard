<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Http\Resources\UserResource;
use App\Models\FcmTokenKey;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserBook;
use App\Models\UserCode;
use App\Models\UserPackage;
use App\Models\UserPoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NewAuthController extends BaseController
{
    /**
     * Login user and create token
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::guard('api')->user()) {
            return $this->sendError(401, 'Already login!');
        }
        // Validate user input
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
            'fcm_token_key' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to log the user in
        $credentials = $request->only('phone', 'password');
        $user = User::withCount('fcmTokenKey')->orWhere('phone', $request->phone)->first();

        if ($request->phone == '95912345678' || $request->phone == '912345678') {
            $otp = 1111;
        } else {
            $otp = rand(1000, 9999);
        }



        // Send OTP via SMS (you should implement this method)
        $smsResponse = $this->sendSMS($user->phone, $otp);

        if (!$smsResponse) {
            return response()->json(['error' => 'Failed to send SMS OTP'], 500);
        }

        Cache::put('login:' . $user->id, [
            'credentials' => $credentials,
            'fcm_token_key' => $request->fcm_token_key,
            'otp' => $otp,
        ], now()->addMinutes(10));

        return response()->json([
            'message' => 'OTP sent to your phone number.',
            'user_id' => $user->id,
            'otp' => $otp
        ], 200);
    }

    public function verifyLoginOtp(Request $request) {
        $otp = $request->input('otp');
        $userId = $request->user_id;

        $userData = Cache::get('login:' . $userId);
        // return $userData['fcm_token_key'];

        if (!$userData) {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }

        if ($otp == $userData['otp']) {
            $user = User::findOrFail($userId);
            $credentials = $userData['credentials'];
            // Create and save the user, code, and FCM token
            if($user->fcm_token_key_count >= 5){
                $firstFcmTokenKey = FcmTokenKey::where('user_id', $user->id)->first();
                $firstFcmTokenKey->update($userData['fcm_token_key']);
            }else {
                FcmTokenKey::create([
                    'user_id' => $user->id,
                    'fcm_token_key' => $userData['fcm_token_key'],
                ]);
            }

            if (Auth::attempt($credentials)) {
                // If the user's credentials are correct, create a new token for the user

                $user = Auth::user();
                $token = $user->createToken(config('app.companyInfo.name'))->accessToken;
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'data' => new UserResource($user),
                ], 200);
            } else {
                // If the user's credentials are incorrect, return an error response
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } else {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }


    }

    public function forgotPassword(Request $request)
    {
        if (Auth::guard('api')->user()) {
            return $this->sendError(401, 'Already login!');
        }
        // Validate user input
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'fcm_token_key' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::withCount('fcmTokenKey')->orWhere('phone', $request->phone)->first();
        if(!$user){
            return $this->sendError(401, 'Phone Number is not registerd!');
        }

        // Generate a random OTP
        $otp = rand(1000, 9999);

        // Send OTP via SMS (you should implement this method)
        $smsResponse = $this->sendSMS($user->phone, $otp);

        if (!$smsResponse) {
            return response()->json(['error' => 'Failed to send SMS OTP'], 500);
        }

        Cache::put('login:' . $user->id, [
            'user' => $user,
            'phone' => $request->phone,
            'fcm_token_key' => $request->fcm_token_key,
            'otp' => $otp,
        ], now()->addMinutes(10));

        return response()->json([
            'message' => 'OTP sent to your phone number.',
            'user_id' => $user->id,
            'otp' => $otp
        ], 200);
    }

    public function verifyForgotOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'password' => 'required|min:6',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $otp = $request->input('otp');
        $userId = $request->user_id;

        $userData = Cache::get('login:' . $userId);
        // return $userData['fcm_token_key'];



        if (!$userData) {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }

        if ($otp == $userData['otp']) {
            $user = User::findOrFail($userId);
            // return $user;
            // Create and save the user, code, and FCM token
            if($user->fcm_token_key_count >= 5){
                $firstFcmTokenKey = FcmTokenKey::where('user_id', $user->id)->first();
                $firstFcmTokenKey->update($userData['fcm_token_key']);
            }else {
                FcmTokenKey::create([
                    'user_id' => $user->id,
                    'fcm_token_key' => $userData['fcm_token_key'],
                ]);
            }

            if ($user->phone == $userData['phone']) {
                $user->password = bcrypt($request->password);
                $user->save();
                // If the user's credentials are correct, create a new token for the user
                Auth::login($user);
                $user = Auth::user();
                // return Auth::user();
                $token = $user->createToken(config('app.companyInfo.name'))->accessToken;
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'data' => new UserResource($user),
                ], 200);
            } else {
                // If the user's credentials are incorrect, return an error response
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } else {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }


    }

    /**
     * Register a new user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => 'required|email|unique:users',
            // 'phone' => 'required', // Ensure phone number uniqueness
            'phone' => 'required|unique:users', // Ensure phone number uniqueness
            'password' => 'required|min:6',
            'fcm_token_key' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Generate a user with encrypted password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        // Generate a unique user code
        $code = UserCode::create([
            'user_id' => $user->id,
            'user_code' => uniqid('wisdom-tree-user'),
        ]);

        // Store the FCM token
        $fcm = FcmTokenKey::create([
            'user_id' => $user->id,
            'fcm_token_key' => $request->fcm_token_key,
        ]);

        if ($request->phone == '95912345678' || $request->phone == '912345678') {
            $otp = 1111;
        } else {
            $otp = rand(1000, 9999);
        }

        // Send OTP via SMS (you should implement this method)
        $smsResponse = $this->sendSMS($request->phone, $otp);

        if (!$smsResponse) {
            return response()->json(['error' => 'Failed to send SMS OTP'], 500);
        }

        // Store user data, code, FCM token, and OTP in the cache
        Cache::put('registration:' . $user->id, [
            'user' => $user,
            'code' => $code,
            'fcm' => $fcm,
            'otp' => $otp,
        ], now()->addMinutes(10));

        return response()->json([
            'message' => 'OTP sent to your phone number.',
            'user_id' => $user->id,
            'otp' => $otp
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');
        $userId = $request->user_id;

        $userData = Cache::get('registration:' . $userId);

        if (!$userData) {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }

        if ($otp == $userData['otp']) {
            // Create and save the user, code, and FCM token
            $user = $userData['user'];
            $code = $userData['code'];
            $fcm = $userData['fcm'];

            $user->save();
            $code->save();
            $fcm->save();

            // Remove the registration data from cache
            Cache::forget('registration:' . $userId);

            // Respond with success and a token
            return response()->json([
                'success' => true,
                'token' => $user->createToken(config('app.companyInfo.name'))->accessToken,
                'data' => new UserResource($user),
            ], 201);
        } else {
            return response()->json(['message' => 'OTP verification failed'], 401);
        }
    }

    public function resendOtp(Request $request)
    {
        $status = '';
        switch ($request->status) {
            case 'login': case 'forgot':
                $status = 'login:';
                $data = Cache::get($status.$request->user_id);
                break;
            case 'register':
                $status = 'registeration:';
                $data = Cache::get($status.$request->user_id);
                break;
        }

        // Generate a random OTP
        $otp = rand(1000, 9999);
        // Send OTP via SMS (you should implement this method)
        $smsResponse = $this->sendSMS($request->phone, $otp);
        if (!$smsResponse) {
            return response()->json(['error' => 'Failed to send SMS OTP'], 500);
        }

        $data['otp'] = $otp;
        Cache::put($status . $request->user_id, $data, now()->addMinutes(10));


        return response()->json([
            'message' => 'OTP sent to your phone number.',
            'user_id' => $request->user_id,
            'otp' => $otp
        ], 200);
    }


    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // return $request;
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function check()
    {
        $now = Carbon::now();

        $checkPackage = UserPackage::with(['user', 'package'])->where('user_id', Auth::guard('api')->user()->id)->where('status', '1')->first();

        if(!$checkPackage){
            return response()->json(["message" => "Your are not a member yet!"]);
        }

        $user = User::with(['packages', 'orders.orderItems', 'userCode', 'userPoint', 'books'])
        ->findOrFail(Auth::guard('api')->user()->id);


        $expireDate = $user->packages[0]->pivot->expire_date ?? $user->packages[0]->pivot->updated_at->copy()->addDays($user->packages[0]->package_duration);

        // Check if the current date is greater than the expiration date
        if ($now->greaterThan(Carbon::parse($expireDate))) {
            $userPackage = UserPackage::where([
                ['user_id', $user->id],
                ['status', '1']
            ])->first();

            if ($userPackage) {
                $userPackage->delete();
                $user->member_status = "0";
                $user->save();
            }

            return response()->json(["message" => "Your package has expired!"]);
        }

        $daysLeft = $now->diffInDays($expireDate);
        return response()->json(["message" => "Your package has " . $daysLeft . " days left!"]);
    }

    public function deleteUser()
    {
        $user = User::findOrFail(Auth::guard('api')->user()->id);

        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }

        $orders = Order::where('user_id' , $user->id)->get();

        if ($orders) {
            foreach ($orders as $key => $value) {
                OrderItem::where('order_id', $value->id)->delete();
                $value->delete();
            }
        }

        $packages = UserPackage::where('user_id', $user->id)->get();
        if($packages){
            foreach ($packages as $key => $value) {
                $value->delete();
            }
        }

        $code = UserCode::where('user_id', $user->id)->first();

        if($code){
            $code->delete();
        }

        $points = UserPoint::where('user_id', $user->id)->first();

        if($points){
            $points->delete();
        }

        $books = UserBook::where('user_id', $user->id)->get();
        if ($books) {
            foreach ($books as $value) {
                $value->delete();
            }
        }

        $user->delete();

        return response()->json(['message' => 'User account and related data deleted successfully']);

    }

    private function sendSMS($phoneNumber, $otp)
    {
        $token = 'z_-ofYj_-BjFTCLsU_cVB3lWE782gzbZtbjFy9ESBFlTca4AEqmg6WYdUgJ3Rols';
        $payload = [
            'to' => $phoneNumber,
            'message' => 'Wisdom Tree Library : Your OTP code is - ' . $otp,
            'sender' => 'Wisdom Tree Library',
        ];

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://smspoh.com/api/v2/send', $payload);

        return $response->successful();
    }
}

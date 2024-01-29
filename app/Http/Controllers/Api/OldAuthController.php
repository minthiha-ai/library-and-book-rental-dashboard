<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NewAuthController extends Controller
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
            'email' => 'required|email',
            'password' => 'required',
            'fcm_token_key' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');

        $user = User::withCount('fcmTokenKey')->orWhere('email', $request->email)->first();


        if($user->fcm_token_key_count >= 5){
            $firstFcmTokenKey = FcmTokenKey::where('user_id', $user->id)->first();
            $firstFcmTokenKey->update([$request->fcm_token_key]);
        }else {
            FcmTokenKey::create([
                'user_id' => $user->id,
                'fcm_token_key' => $request->fcm_token_key,
            ]);
        }

        // return $user;
        // return new UserResource($user);
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
    }

    /**
     * Register a new user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
            'fcm_token_key' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Generate OTP and send it via SMS
        $otp = rand(1000, 9999);
        $smsResponse = $this->sendSMS($request->phone, $otp);

        if (!$smsResponse) {
            return response()->json(['error' => 'Failed to send SMS OTP'], 500);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $user_code = new UserCode();
        $user_code->user_id = $user->id;
        $user_code->user_code = uniqid('wisdom-tree-user');
        $user_code->save();

        // Create a new token for the user inside the transaction
        FcmTokenKey::create([
            'user_id' => $user->id,
            'fcm_token_key' => $request->fcm_token_key,
        ]);

        // Store the OTP in the user's cache
        Cache::put('otp_' . $user->id, $otp, now()->addMinutes(5));

        // Return a response indicating that the OTP has been sent
        return response()->json(['message' => 'OTP sent successfully'], 200);

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

        $data = User::with(['packages', 'orders.orderItems','userCode','userPoint','books'])->findOrFail(Auth::guard('api')->user()->id);

        if($now->diffInDays($data->packages[0]->pivot->updated_at) > $data->packages[0]->package_duration){
            // return response()->json(["message" => "Your package is expired"]);
            $userPackage = UserPackage::where([
                ['user_id',$data->id],
                ['status', '1']
            ])->first();
            $userPackage->delete();
            $data->member_status = "0";
            $data->save();
            // return $userPackage;
            return response()->json(["message" => "Your package is expired!"]);
        }
        return response()->json(["message" => "Your package is ".($data->packages[0]->package_duration - $now->diffInDays($data->packages[0]->pivot->updated_at))." days left!"]);
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
}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\SubscriptionResource;
use App\Models\User;

class MemberSubscribeController extends BaseController
{
    protected $path = 'storage/images/payment/';

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'package_id' => 'required',
            'payment_id' => 'required',
            'payment_photo' => 'required',
        ]);
        if(Auth::guard('api')->user()->isBanned == '1'){
            return $this->sendError(401, 'You have been banned from this Application!');
        }

        $data = $this->getSubscribeData($request);
        DB::beginTransaction();
        try {
            // $check = UserPackage::where('user_id', Auth::guard('api')->user()->id)->where('package_id',$request->package_id)->first();
            $check = User::withCount('packages')->findOrFail(Auth::guard('api')->user()->id);
            // return $check;
            if ($check->packages_count != 0) {
                return $this->sendError(201, 'You have already subscribed the package!');
            }
            $subscribe = UserPackage::create($data);
            DB::commit();
            $message = 'Package subscription success. Please wait for confirmation.';
            sendPushNotification('Package subscribe.', $message, Auth::guard('api')->user()->id);
            return $this->sendResponse($message, new SubscriptionResource($subscribe));
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            return $this->sendError(500, 'Something wrong!Please Try Again.');
        }
    }

    protected function getSubscribeData($request)
    {
        $data = [
            'user_id' => Auth::guard('api')->user()->id,
            'package_id' => $request->package_id,
            'payment_id' => $request->payment_id,
        ];

        if ($request->hasFile('payment_photo')) {
            $image = $request->file('payment_photo');
            $photoName = uniqid('payment').'.'.$image->extension();
            $data['payment_photo'] = $photoName;
            $image->move(public_path($this->path), $photoName);
        }
        return $data;
    }
}

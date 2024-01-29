<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MemberResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MemberController extends BaseController
{
    public function getData()
    {
        $data = User::with(['packages', 'orders.orderItems', 'userCode', 'userPoint', 'fcmTokenKey'])->findOrFail(Auth::guard('api')->user()->id);
        // return $data;
        return $this->sendResponse('success', new MemberResource($data));
    }

    public function getOrderHistories()
    {
        $data = Order::with(['user','region.delivery_fees','orderItems.book'])->where('user_id', Auth::guard('api')->user()->id)->get();
        // return $data;
        return $this->sendResponse('success', OrderResource::collection($data));
    }
}

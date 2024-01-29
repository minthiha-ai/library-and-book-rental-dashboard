<?php

namespace App\Http\Controllers\Api;

use App\Models\CreditPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\OrderPoint;
use App\Models\UserPackage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditPointController extends BaseController
{
    protected $path = 'storage/images/payment/';

    public function index(){
        $data = CreditPoint::orderBy('id', 'DESC')->get();
        if(!count($data)){
            return $this->sendError(204,'No Data Found');
        }
        return $this->sendResponse('success',$data);
    }

    public function purchase(Request $request)
    {
        $this->validate($request, [
            'point_id' => 'required',
            'payment_id' => 'required',
            'payment_photo' => 'required'
        ]);

        if(Auth::guard('api')->user()->isBanned == '1'){
            return $this->sendError(401, 'You have been banned from this Application!');
        }
        $user_id = Auth::guard('api')->user()->id;
        $checkPackage = UserPackage::with(['user', 'package'])->where('user_id', $user_id)->where('status', '1')->first();

        // return $checkPackage;
        if (!$checkPackage) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to proceed the order!',
                'error' => "You haven't subscribed to a package yet.",
            ], 201);
        }
        $orderData = $this->getRequestedData($request);

        DB::beginTransaction();
        try {
            $order = OrderPoint::create($orderData);

            DB::commit();
            sendPushNotification('Success', 'Order placed successfully.', Auth::guard('api')->user()->id);
            return $this->sendResponse('Order placed successfully.', $order);
        } catch (Exception $th) {
            DB::rollBack();
            return $this->sendError(500, 'Something went wrong! Please try again.');
        }
    }

    private function getRequestedData($request)
    {
        $data = [
            'user_id' => Auth::guard('api')->user()->id,
            'credit_point_id' => $request->point_id,
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

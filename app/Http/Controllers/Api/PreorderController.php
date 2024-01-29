<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserBook;
use App\Models\UserPackage;
use App\Models\UserPoint;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PreorderController extends BaseController
{
    protected $path = 'storage/images/payment/';

    public function preOrder(Request $request){
        if(Auth::guard('api')->user()->isBanned == '1'){
            return $this->sendError(401, 'You have been banned from this Application!');
        }
        $user_id = Auth::guard('api')->user()->id;

        // return Auth::guard('api')->user()->userPoint->point;
        if (Auth::guard('api')->user()->userPoint == null) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to pre order book!',
                'error' => "You don't have any credit point!",
            ], 201);
        }

        if(Auth::guard('api')->user()->userPoint->point < $request->total_point){
            return response()->json([
                'result' => 0,
                'message' => 'Fail to pre order book!',
                'error' => "You don't have enough credit point!",
            ], 201);
        }



        // $point = UserPoint::where('user_id', $user_id)->first();
        // $point->point -= $request->total_point;
        // $point->save();

        $checkPackage = UserPackage::with(['user', 'package'])->where('user_id', $user_id)->where('status', '1')->first();

        if (!$checkPackage) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You haven't subscribed to a package yet.",
            ], 201);
        }

        $orderData = $this->getRequestOrderData($request);

        DB::beginTransaction();
        try {
            $order = Order::create($orderData);

            if (count($request->input('books')) <= $checkPackage->package->book_per_rent) {
                $orderItemsData = $this->getRequestOrderItemsData($request, $order->id);
                foreach ($request->input('books') as $value) {
                    $data = new UserBook();
                    $data->user_id = Auth::guard('api')->user()->id;
                    $data->book_id = $value["book_id"];
                    $data->order_id = $order->id;
                    $data->status = 'reserved';
                    $data->save();
                }
                OrderItem::insert($orderItemsData);
            } else {
                return response()->json([
                    'result' => 0,
                    'message' => 'Fail to rent book!',
                    'error' => "You have exceeded the limit of books you can rent.",
                ], 201);
            }

            DB::commit();
            sendPushNotification('Success','Order placed successfully.',$user_id);
            return $this->sendResponse('Order placed successfully.', $order);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError(500, 'Something went wrong! Please try again.');
        }
    }

    private function getRequestOrderData($request)
    {
        $data = [
            'user_id' => Auth::guard('api')->user()->id,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => 'preorder',
            'state' => 'progressing',
            'delivery_fee' => $request->input('delivery_fee'),
            'region_id' => $request->input('region_id'),
            'delivery_fee_id' => $request->input('delivery_fee_id'),
            'credit_point' => $request->input('total_point'),
        ];


        return $data;
    }

    private function getRequestOrderItemsData($request, $orderId)
    {
        $orderItems = [];

        foreach ($request->input('books') as $value) {
            $book = Book::find($value['book_id']);

                $orderItem = [
                    'order_id' => $orderId,
                    'book_id' => $book->id,
                    'quantity' => 1,
                ];
                // $book->remain -= 1;
                // $book->update();
                $orderItems[] = $orderItem;


        }

        return $orderItems;
    }
}

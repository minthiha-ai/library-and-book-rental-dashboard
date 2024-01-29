<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Book;
use App\Models\Order;
use App\Models\RentBook;
use App\Models\OrderItem;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentController extends BaseController
{
    protected $path = 'storage/images/payment/';

    public function rent(Request $request)
    {
        if(Auth::guard('api')->user()->isBanned == '1'){
            return $this->sendError(401, 'You have been banned from this Application!');
        }
        $user_id = Auth::guard('api')->user()->id;

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
                foreach ($request->input('books') as $value) {
                    $book = Book::find($value['book_id']);
                    if ($book->remain == 0) {
                        return response()->json([
                            'result' => 0,
                            'message' => 'Fail to rent book!',
                            'error' => "There is no remaining book for ".$book->title.".",
                        ], 201);
                    }
                }

                $orderItemsData = $this->getRequestOrderItemsData($request, $order->id);

                OrderItem::insert($orderItemsData);
            } else {
                return response()->json([
                    'result' => 0,
                    'message' => 'Fail to rent book!',
                    'error' => "You have exceeded the limit of books you can rent.",
                ], 201);
            }

            DB::commit();

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
            'status' => 'pending',
            'state' => 'progressing',
            'delivery_fee' => $request->input('delivery_fee'),
            'region_id' => $request->input('region_id'),
            'delivery_fee_id' => $request->input('delivery_fee_id'),
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
                $book->remain -= 1;
                $book->update();
                $orderItems[] = $orderItem;


        }

        return $orderItems;
    }

    public function returnBook(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required'
        ]);

        $order = Order::find($request->order_id);
        $order->state = 'returned';
        $order->save();

        $item = OrderItem::where('order_id', $request->order_id)->get();
        // $books = [];
        foreach ($item as $key => $value) {
            $book = Book::find($value->book_id);
            // $books[] = $book;
            $book->remain += 1;
            $book->save();
        }
        return $this->sendResponse('Books returned successfully.', $order);
    }
}


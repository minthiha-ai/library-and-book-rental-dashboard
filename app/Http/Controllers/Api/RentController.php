<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Book;
use App\Models\FcmTokenKey;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnDay;
use App\Models\Setting;
use App\Models\UserBook;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RentController extends BaseController
{
    protected $path = 'storage/images/payment/';

    public function rent(Request $request)
    {
        if (Auth::guard('api')->user()->isBanned == '1') {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to sent request',
                'error' => "You have been banned from this Application!",
            ], 401);
        }

        $user_id = Auth::guard('api')->user()->id;
        $checkPackage = UserPackage::with(['user', 'package'])->where('user_id', $user_id)->where('status', '1')->first();

        if ($checkPackage->expire_date !== null) {
            $remainDays = Carbon::parse($checkPackage->expire_date)->diffInDays(Carbon::now());
        }else{
            $remainDays = $checkPackage->package->package_duration - $checkPackage->updated_at->diffInDays(Carbon::now());
        }
        // return $remainDays;
        if ($remainDays < 7) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You only left ".$remainDays." days for your package!",
            ], 400);

        }

        // return $checkPackage;
        if (!$checkPackage) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You haven't subscribed to a package yet.",
            ], 201);
        }
        $activeOrder = Order::where('user_id', $user_id)
            ->where('state', '!=', 'returned')
            ->first();

        if ($activeOrder) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You cannot place a new order until your previous order is returned.",
            ], 400);
        }

        // Check if the user has already requested the same books
        $alreadyRequested = OrderItem::whereHas('order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('state', '!=', 'returned');
        })->whereIn('book_id', collect($request->input('books'))->pluck('book_id'))->exists();

        if ($alreadyRequested) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You have already requested one or more of these books.",
            ], 201);
        }

        // Check if the user has requested the same books within the last 7 days
        $previousRequested = OrderItem::whereHas('order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('state', '!=', 'returned');
        })->whereIn('book_id', collect($request->input('books'))->pluck('book_id'))
        ->where('created_at', '>=', Carbon::now('Asia/Yangon')->subDays(7))->exists();

        if ($previousRequested) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You have requested one or more of these books within the last 7 days.",
            ], 201);
        }

        // Check if the number of books to rent exceeds the package limit within the time limit
        $totalBooksRented = OrderItem::whereHas('order', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->where('state', '!=', 'returned');
        })->where('created_at', '>=', Carbon::now('Asia/Yangon')->subDays($checkPackage->package->time_limit_in_days))
        ->sum('quantity');

        if (($totalBooksRented + count($request->input('books'))) > $checkPackage->package->book_per_rent) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => "You have exceeded the book rental limit within the package time limit.",
            ], 201);
        }

        $orderData = $this->getRequestOrderData($request);


        DB::beginTransaction();
        try {
            $order = Order::create($orderData);

            if (count($request->input('books')) <= $checkPackage->package->book_per_rent) {
                $orderItemsData = Order::createOrderItems($order->id, $request->input('books'));
                // return $orderItemsData;
                // $data = [];
                foreach ($request->input('books') as $value) {
                    $data = new UserBook();
                    $data->user_id = Auth::guard('api')->user()->id;
                    $data->book_id = $value["book_id"];
                    $data->order_id = $order->id;
                    $data->status = 'pending';
                    $data->save();
                }
                // return $data;

                OrderItem::insert($orderItemsData);


            } else {
                return response()->json([
                    'result' => 0,
                    'message' => 'Fail to rent book!',
                    'error' => "You have exceeded the limit of books you can rent.",
                ], 201);
            }

            DB::commit();
            sendPushNotification('Success', 'Order placed successfully', $user_id);
            return $this->sendResponse('Order placed successfully.', $order);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError(500, 'Something went wrong! Please try again. error:'.$e);
        }
    }

    private function getRequestOrderData($request)
    {
        return [
            'user_id' => Auth::guard('api')->user()->id,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => 'pending',
            'state' => 'progressing',
            'delivery_fee' => $request->input('delivery_fee'),
            'region_id' => $request->input('region_id'),
            'delivery_fee_id' => $request->input('delivery_fee_id'),
            'books' => $request->books
        ];
    }

    public function returnBook(Request $request)
    {

        $this->validate($request, [
            'order_id' => 'required'
        ]);

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json([
                'result' => 0,
                'message' => 'Order not found!',
                'error' => "The order you're trying to return doesn't exist.",
            ], 404);
        }

        if ($order->state == 'returned') {
            return response()->json([
                'result' => 0,
                'message' => 'Already returned the books!',
                'error' => "You have already returned the books you rented.",
            ], 403);
        }

        $setting = Setting::latest()->first();
        $day = ReturnDay::latest()->first();
        if (!$setting->status) {
            if (!$order->returnable($order->updated_at, $order->state)) {
                return response()->json([
                    'result' => 0,
                    'message' => 'Cannot return the book yet!',
                    'error' => "You can't return the book within ".$day->day." days!",
                ], 403);
            }
        }



        DB::beginTransaction();
        try {
            // Update the order state to 'returned'
            $order->state = 'returned';
            $order->save();

            // Update book quantities and user book statuses
            $items = $order->orderItems;
            // $book = [];


            foreach ($items as $item) {
                $book = Book::with('users')->find($item->book_id);

                if ($book) {
                    $hasReservedUser = false; // Flag to check if there's a reserved user

                    foreach ($book->users as $user) {
                        if ($user->pivot->status === 'reserved') {
                            $hasReservedUser = true;
                            break; // No need to check other users for this book
                        }
                    }

                    if (!$hasReservedUser) {
                        $book->increment('remain');
                    }

                    // Update UserBook status to 'returned'
                    UserBook::where('order_id', $order->id)
                        ->where('book_id', $item->book_id)
                        ->update(['status' => 'returned']);
                }
            }
            UserBook::where('user_id', Auth::guard('api')->user()->id)->delete();

            DB::commit();

            sendPushNotification('Books returned!', "Books have been returned", $order->user_id);

            return $this->sendResponse('Books returned successfully.', $order);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError(500, 'Something went wrong! Please try again. Error: ' . $e->getMessage());
        }
    }


}

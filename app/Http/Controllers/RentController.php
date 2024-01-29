<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Http\Requests\StoreRentRequest;
use App\Models\Book;
use App\Models\FcmTokenKey;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserBook;
use App\Models\UserPoint;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getOrdersByStatus('all');
        // return $data;
        return view('backend.rent.index', compact('data'));
    }

    public function pending()
    {
        $data = $this->getOrdersByStatus('pending');
        return view('backend.rent.pending', compact('data'));
    }

    public function confirmed()
    {
        $data = $this->getOrdersByStatus('success');
        return view('backend.rent.confirm', compact('data'));
    }

    public function reserved()
    {
        $data = $this->getOrdersByStatus('preorder');
        return view('backend.rent.preorder', compact('data'));
    }

    private function getOrdersByStatus($status)
    {
        $query = Order::with(['user', 'region.delivery_fees', 'orderItems.book'])
            ->orderBy('id', 'desc')
            ->when(isset(request()->search), function ($q) {
                $search = request()->search;
                return $q->where("phone", "like", "%$search%");
            })
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        return $query->paginate(10);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with(['user','region','deliveryFee','orderItems.book'])->findOrFail($id);
        // return $data;
        return view('backend.rent.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRentRequest  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);
        $data = Order::with(['user.packages', 'orderItems'])->findOrFail($id);
        // return $data;

        switch ($request->status) {
            case 'preorder':
                $data->start_date = '';
                $data->overdue_date = '';
                $data->state = 'progressing';
                $data->status = 'preorder';
                break;
            case 'pending':
                $data->start_date = '';
                $data->overdue_date = '';
                $data->state = 'progressing';
                $data->status = 'pending';
                break;
            case 'success':
                if($data->status == 'preorder'){
                    $point = UserPoint::where('user_id', $data->user_id)->first();
                    // return $point;
                    if($point){
                        $point->point -= $data->credit_point;
                        $point->save();
                    }
                }

                if($data->status == 'pending'){
                    foreach ($data->orderItems as $value) {
                        $book = Book::find($value['book_id']);
                        if ($book->remain == 0) {
                            return back()->with("error","There is no remaining book for " . $book->title . ".");
                        }
                        $book->remain -= 1;
                        $book->save();
                    }
                }

                $userId = $data->user_id;
                $orderId = $data->id;
                UserBook::where('order_id', $orderId)
                    ->whereIn('user_id', function ($query) use ($userId) {
                        $query->select('user_id')
                            ->from('orders')
                            ->where('user_id', $userId);
                    })
                    ->update(['status' => 'rented']);

                $data->start_date = Carbon::now('Asia/Yangon')->format('Y-m-d\TH:i:s.u\Z');
                $data->overdue_date = Carbon::now('Asia/Yangon')->addDays($data->user->packages[0]->rent_duration)->format('Y-m-d\TH:i:s.u\Z');
                $data->state = 'rented';
                $data->status = 'success';
                break;
        }
        sendPushNotification('Order ' . $request->status, 'Your order has been ' . $request->status  . " by " . config('app.companyInfo.name'), $data->user_id);
        $data->save();
        return redirect(route('rent.index'))->with('success', 'Rent request confirm successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        UserBook::where('order_id', $order->id)->delete();
        $order->delete();

        return back()->with('success','Order data deleted successfully');
    }
}

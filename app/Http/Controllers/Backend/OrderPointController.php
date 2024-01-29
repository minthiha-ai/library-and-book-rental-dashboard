<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OrderPoint;
use App\Models\UserPoint;
use Illuminate\Http\Request;

class OrderPointController extends Controller
{
    protected $path = 'storage/images/payment/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OrderPoint::with(['user.userCode','credit_point','payment'])->orderBy('id', 'desc')->paginate(10);
        return view('backend.order-points.index', compact('data'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = OrderPoint::findOrFail($id);
        return view('backend.order-points.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $orderPoint = OrderPoint::findOrFail($id);
        $orderPoint->status = $request->status;
        $orderPoint->save();

        $userPoint = UserPoint::firstOrNew(['user_id' => $orderPoint->user_id]);
        $userPoint->point += $orderPoint->credit_point->point;
        $userPoint->save();

        return redirect()->route('order-points.index')->with('success', 'Credit point purchase approved successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = OrderPoint::findOrFail($id);

        if($data->payment_photo != ''){
            if(file_exists($this->path.$data->payment_photo)){
                unlink(public_path($this->path).$data->payment_photo);
            }
        }

        $data->delete();

        return back()->with('success', 'Order deleted successfully');
    }
}

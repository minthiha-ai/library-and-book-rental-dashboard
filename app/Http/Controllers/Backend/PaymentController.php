<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $path = 'storage/images/payment/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payment::orderby('id', 'desc')->paginate(10);
        return view('backend.payment.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'payment_type' => 'required',
            'name' => 'required',
            'number' => 'required',
            'qr_image' => 'required',
        ]);

        $data = new Payment();
        $data->payment_type = $request->payment_type;
        $data->name = $request->name;
        $data->number = $request->number;

        $photoName = uniqid('payment').'.'.$request->image[0]->extension();
        $data->payment_logo = $photoName;

        $qrName = uniqid('payment').'.'.$request->qr_image[0]->extension();
        $data->qr = $qrName;


        if ($data->save()) {
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            if($request->qr_image){
                $request->qr_image[0]->move(public_path($this->path), $qrName);
            }
            return to_route('payments.index')->with('success', 'Payment updated successfully!');
        }else{
            return back()->with('warning', 'Something wrong');
        }

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
        $data = Payment::findOrFail($id);
        return view('backend.payment.edit', compact('data'));
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
        $this->validate($request, [
            'payment_type' => 'required',
            'name' => 'required',
            'number' => 'required'
        ]);

        $data = Payment::findOrFail($id);
        $data->payment_type = $request->payment_type;
        $data->name = $request->name;
        $data->number = $request->number;

        if ($request->image) {
            if ($data->payment_logo != '') {
                if(file_exists(public_path(($this->path).$data->payment_logo))){
                    unlink(public_path($this->path).$data->payment_logo);
                }
            }
            $photoName = uniqid('payment').'.'.$request->image[0]->extension();
            $data->payment_logo = $photoName;
        }
        if ($request->qr_image) {
            if ($data->qr != '') {
                if(file_exists(public_path(($this->path).$data->qr))){
                    unlink(public_path($this->path).$data->qr);
                }
            }
            $qrName = uniqid('payment').'.'.$request->qr_image[0]->extension();
            $data->qr = $qrName;
        }


        if ($data->save()) {
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            if($request->qr_image){
                $request->qr_image[0]->move(public_path($this->path), $qrName);
            }
            return to_route('payments.index')->with('success', 'Payment updated successfully!');
        }else{
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Payment::findOrFail($id);
        if ($data->payment_logo != '') {
            if(file_exists($this->path.$data->payment_logo)){
                unlink(public_path($this->path).$data->payment_logo);
            }
        }
        $data->delete();

        return back()->with('success', 'Payment deleted Successfully');
    }
}

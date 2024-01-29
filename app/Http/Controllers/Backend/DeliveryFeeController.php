<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DeliveryFee;
use App\Models\Region;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DeliveryFee::with('region')->orderby('id', 'desc')->paginate(10);
        return view('backend.delivery-fee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        return view('backend.delivery-fee.create', compact('regions'));
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
            'region_id' => 'required',
            'city' => 'required',
            'fee' => 'required',
        ]);

        $data = new DeliveryFee();
        $data->region_id = $request->region_id;
        $data->city = $request->city;
        $data->fee = $request->fee;
        $data->save();

        return to_route('delivery-fees.index')->with('success', 'Delivery Fee created successfully');
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
        $regions = Region::all();
        $data = DeliveryFee::findOrFail($id);

        return view('backend.delivery-fee.edit', compact('regions', 'data'));
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
            'region_id' => 'required',
            'city' => 'required',
            'fee' => 'required',
        ]);

        $data = DeliveryFee::findOrFail($id);
        $data->region_id = $request->region_id;
        $data->city = $request->city;
        $data->fee = $request->fee;
        $data->save();

        return to_route('delivery-fees.index')->with('success', 'Delivery Fee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeliveryFee::findOrFail($id)->delete();

        return back()->with('success', 'Delivery fee deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreditPoint;
use App\Models\OrderPoint;
use Illuminate\Http\Request;

class CreditPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CreditPoint::orderBy('id', 'desc')->paginate(10);
        return view('backend.credit-points.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.credit-points.create');
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
            'point' => 'required',
            'price' => 'required'
        ]);

        $data = new CreditPoint();
        $data->point = $request->point;
        $data->price = $request->price;
        $data->save();

        return to_route('credit-points.index')->with('success', 'Point created successfully');
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
        $data = CreditPoint::findOrFail($id);
        return view('backend.credit-points.edit', compact('data'));
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
            'point' => 'required',
            'price' => 'required'
        ]);

        $data = CreditPoint::findOrFail($id);
        $data->point = $request->point;
        $data->price = $request->price;
        $data->save();

        return to_route('credit-points.index')->with('success', 'Point updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CreditPoint::findOrFail($id)->delete();

        return back()->with('success', 'Point deleted successfully');
    }

}

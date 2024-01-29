<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $path = 'storage/images/package/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Package::orderby('id', 'desc')->paginate(10);
        return view('backend.package.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.package.create');
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
            'title' => 'required',
            'package_duration' => 'required',
            'book_per_rent' => 'required',
            'rent_duration' => 'required',
            'price' => 'required',
            'overdue_price_per_day' => 'required',
            'overdue_price_per_week' => 'required',
            'overdue_price_per_month' => 'required',
        ]);

        $data = new Package();
        $data->title = $request->title;
        $data->package_duration = $request->package_duration;
        $data->book_per_rent = $request->book_per_rent;
        $data->rent_duration = $request->rent_duration;
        $data->price = $request->price;
        $data->overdue_price_per_day = $request->overdue_price_per_day;
        $data->overdue_price_per_week = $request->overdue_price_per_week;
        $data->overdue_price_per_month = $request->overdue_price_per_month;

        if ($request->image) {
            $photoName = uniqid('package').'.'.$request->image[0]->extension();
            $data->image = $photoName;
        }else{
            $data->image = '';
        }

        if($data->save()){
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('packages.index')->with('success', 'Package created successfully');
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
        $data = Package::findOrFail($id);
        return view('backend.package.edit', compact('data'));
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
            'title' => 'required',
            'package_duration' => 'required',
            'book_per_rent' => 'required',
            'rent_duration' => 'required',
            'price' => 'required',
            'overdue_price_per_day' => 'required',
            'overdue_price_per_week' => 'required',
            'overdue_price_per_month' => 'required',
        ]);

        $data = Package::findOrFail($id);
        $data->title = $request->title;
        $data->package_duration = $request->package_duration;
        $data->book_per_rent = $request->book_per_rent;
        $data->rent_duration = $request->rent_duration;
        $data->price = $request->price;
        $data->overdue_price_per_day = $request->overdue_price_per_day;
        $data->overdue_price_per_week = $request->overdue_price_per_week;
        $data->overdue_price_per_month = $request->overdue_price_per_month;

        if ($request->image) {
            if($data->image != ''){
                if (file_exists($this->path.$data->image)) {
                    unlink(public_path($this->path).$data->image);
                }
            }
            $photoName = uniqid('cover').'.'.$request->image[0]->extension();
            $data->image = $photoName;
        }

        if ($data->save()) {
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('packages.index')->with('success', 'Package updated successfully');
        } else {
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
        $data = Package::findOrFail($id);
        if ($data->image != '') {
            if(file_exists($this->path.$data->image)){
                unlink(public_path($this->path).$data->image);
            }
        }
        $data->delete();

        return back()->with('success', 'Package deleted successfully');
    }
}

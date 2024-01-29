<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $path = 'storage/images/banner/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Banner::orderby('id', 'desc')->paginate(10);

        return view('backend.banner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
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
            'image' => 'required',
        ]);

        $data = new Banner();
        $data->title = $request->title;

        $photoName = uniqid('banner').'.'.$request->image[0]->extension();
        $data->image = $photoName;


        if ($data->save()) {
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('banner.index')->with('success', 'Banner created successfully!');
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
        $data = Banner::findOrFail($id);
        return view('backend.banner.edit', compact('data'));
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
        ]);

        $data = Banner::findOrFail($id);
        $data->title = $request->title;
        if ($request->image) {
            if ($data->image != '') {
                if (file_exists(public_path($this->path).$data->image)) {
                    unlink(public_path($this->path).$data->image);
                }
            }
            $photoName = uniqid('banner').'.'.$request->image[0]->extension();
            $data->image = $photoName;
        }



        if ($data->save()) {
            if($request->image){
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('banner.index')->with('success', 'Banner updated successfully!');
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
        $data = Banner::findOrFail($id);
        if ($data->image != '') {
            if(file_exists($this->path.$data->image)){
                unlink(public_path($this->path).$data->image);
            }
        }
        $data->delete();

        return back()->with('success', 'Banner deleted Successfully');
    }
}

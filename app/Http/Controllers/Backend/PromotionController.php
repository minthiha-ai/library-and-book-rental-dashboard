<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $path = 'storage/images/promotion/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Promotion::orderby('id', 'desc')->paginate(10);

        return view('backend.promotions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.promotions.create');
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
            'description' => 'required',
        ]);

        $data = new Promotion();
        $data->title = $request->title;
        $data->description = $request->description;

        $photoName = uniqid('promo') . '.' . $request->image[0]->extension();
        $data->image = $photoName;


        if ($data->save()) {
            if ($request->image) {
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('promotions.index')->with('success', 'Promotion created successfully!');
        } else {
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        return view('backend.events.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $promotion->title = $request->title;
        $promotion->description = $request->description;
        if ($request->image) {
            if ($promotion->image != '') {
                if (file_exists(public_path($this->path) . $promotion->image)) {
                    unlink(public_path($this->path) . $promotion->image);
                }
            }
            $photoName = uniqid('promo') . '.' . $request->image[0]->extension();
            $promotion->image = $photoName;
        }



        if ($promotion->save()) {
            if ($request->image) {
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('promotions.index')->with('success', 'Promotion updated successfully!');
        } else {
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        if ($promotion->image != '') {
            if (file_exists($this->path . $promotion->image)) {
                unlink(public_path($this->path) . $promotion->image);
            }
        }
        $promotion->delete();

        return back()->with('success', 'Promotion deleted Successfully');
    }
}

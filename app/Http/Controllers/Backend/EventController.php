<?php

namespace App\Http\Controllers\Backend;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    protected $path = 'storage/images/event/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Event::orderby('id','desc')->paginate(10);

        return view('backend.events.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.events.create');
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

        $data = new Event();
        $data->title = $request->title;
        $data->description = $request->description;

        $photoName = uniqid('event') . '.' . $request->image[0]->extension();
        $data->image = $photoName;


        if ($data->save()) {
            if ($request->image) {
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('events.index')->with('success', 'Event created successfully!');
        } else {
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('backend.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $event->title = $request->title;
        $event->description = $request->description;
        if ($request->image) {
            if ($event->image != '') {
                if (file_exists(public_path($this->path) . $event->image)) {
                    unlink(public_path($this->path) . $event->image);
                }
            }
            $photoName = uniqid('event') . '.' . $request->image[0]->extension();
            $event->image = $photoName;
        }



        if ($event->save()) {
            if ($request->image) {
                $request->image[0]->move(public_path($this->path), $photoName);
            }
            return to_route('events.index')->with('success', 'Event updated successfully!');
        } else {
            return back()->with('warning', 'Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if ($event->image != '') {
            if (file_exists($this->path . $event->image)) {
                unlink(public_path($this->path) . $event->image);
            }
        }
        $event->delete();

        return back()->with('success', 'Event deleted Successfully');
    }
}

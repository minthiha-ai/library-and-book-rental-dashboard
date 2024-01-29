<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReturnDay;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function index() {
        $data = Setting::all();
        $days = ReturnDay::latest()->first();
        // return $days;
        return view('backend.setting', compact('data', 'days'));
    }

    public function changeSetting($id)
    {
        $data = Setting::findOrFail($id);

        $data->update([
            'status' => !$data->status
        ]);

        return response()->json('success');
    }

    public function changeDay(Request $request)
    {
        $data = ReturnDay::latest()->first();
        $data->day = $request->day;
        $data->save();

        return response()->json('success');
    }
}

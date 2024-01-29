<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\UserCode;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberSubscribeController extends Controller
{
    public function index()
    {
        $search = request()->input('search');

        $data = UserPackage::with(['user', 'package', 'payment'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%$search%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.member-subscribes.index', compact('data'));
    }


    public function edit($id)
    {
        $data = UserPackage::with(['user', 'package', 'payment'])->findOrFail($id);
        // return $data;
        return view('backend.member-subscribes.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $data = UserPackage::findOrFail($id);
        $data->status = $request->status;
        $data->save();
        $user = User::find($data->user_id);
        $user->member_status = '1';
        $user->save();
        $userCode = UserCode::where('user_id',$data->user_id)->first();
        $userCode->member_code = uniqid('wisdom-tree-member');
        $userCode->save();

        sendPushNotification('Subscription complete!', 'Admin has approved your subscription!', $user->id);

        // $member_code = UserCode::where('user_id', $data->user_id)->;

        return to_route('subscribe.index')->with('success', 'Package subscription accept successfully!');
    }

    public function destroy($id)
    {

        $user = UserPackage::find($id);

        $status = User::find($user->user_id);
        $status->member_status = '1';
        $status->save();
        $user->delete();
        return back()->with('success', 'Request deleted successfully');
    }
}

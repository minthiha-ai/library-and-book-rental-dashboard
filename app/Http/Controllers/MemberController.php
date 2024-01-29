<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\UserPackage;
use App\Models\UserPoint;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::with(['packages', 'orders.orderItems','userCode','userPoint'])->where('member_status', 1)->when(isset(request()->search),function ($q){
            $search=request()->search;
            return $q->where("name","like","%$search%")->orwhere("phone","like","%$search%");
        })->latest()->paginate(10);
        // return $members;
        // return $members[7]->packages;
        return view('backend.member.index', compact('members'));
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
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with(['orders.orderItems'])->findOrFail($id);
        // return $data;
        return view('backend.member.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member= User::with(['packages','orders.orderItems','userCode', 'userPoint'])->findOrFail($id);
        // return $member;
        return view('backend.member.edit',compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $data = User::findOrFail($id);
        // return $request->all();
        $package = UserPackage::where('user_id', $id)->latest()->first();
        $package->expire_date = $request->exprie_date;
        $package->save();

        if($request->point){
            $point = UserPoint::where('user_id', $id)->latest()->first();
            if ($point) {
                $point->point = $request->point;
                $point->save();
            }else{
                return back()->with('error', 'User have not purchase the points');
            }
        }

        return redirect()->route('members.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return back()->with('success','Member account deleted successfully');
    }
}

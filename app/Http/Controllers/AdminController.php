<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Opportunity;
use App\Models\Rent;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function changePassword()
    {
        return  view('backend.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        request()->validate([
            'old'=> ['required',new MatchOldPassword()],
            'new'=> ['required','min:8'],
            'reenter'=> ['required','same:new'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new)]);
        Auth::logout();
        return redirect()->route('login');
    }

    public function users()
    {
        $users=User::with('userCode')->where('role','user')->when(isset(request()->search),function ($q){
            $search=request()->search;
            return $q->where("name","like","%$search%")->orwhere("phone","like","%$search%");
        })->latest()->get();
        // return $users;
        return view('backend.user.index',compact('users'));
    }

    public function memberRequest()
    {
        $members=Member::where('status','0')->get();
        return view('backend.member.request',compact('members'));
    }

    public function acceptMember($id)
    {
        $member=Member::find($id);
        $member->status='1';
        $member->save();
        return back()->with('success','Member is accepted successfully');
    }
    public function rejectMember($id)
    {
        DB::delete('DELETE FROM members WHERE id = ?', [$id]);
        return redirect()->back()->with('success','Member request is rejected successfully');
    }

    public function members()
    {
        $members=Member::where('status','1')->when(isset(request()->search),function ($q){
        $search=request()->search;
        return $q->where("name","like","%$search%")->orwhere("phone","like","%$search%");
    })->latest()->get();
        return view('backend.member.index',compact('members'));
    }

    public function editMember($id)
    {
        $member=Member::find($id);
        return view('backend.member.edit',compact('member'));
    }
    public function updateMember(Request $request,$id)
    {
        request()->validate([
            'name'=>'required',
            'phone'=>'required',
            'class'=>'required',
        ]);
        $member=Member::find($id);
        $member->name=$request->name;
        $member->phone=$request->phone;
        $member->class=$request->class;
        $member->update();
        return redirect()->route('member.index')->with('success','Member updated successfully');
    }

    public function opportunityCreate()
    {
        return view('backend.member.opportunity');
    }

    public function opportunityStore(Request $request)
    {
        $opportunity=new Opportunity();
        $opportunity->member_type=$request->member_type;
        $opportunity->no_of_book=$request->no_of_book;
        $opportunity->life_time=$request->life_time;
        $opportunity->overdue_price_per_day=$request->overdue_price_per_day;
        $opportunity->overdue_price_per_week=$request->overdue_price_per_week;
        $opportunity->overdue_price_per_month=$request->overdue_price_per_month;
        $opportunity->save();
        return redirect()->back()->with('success','Member Opportunity is set successfully.');
    }

    public function rentBooks()
    {
        $book_id=Rent::pluck('book_id');
        $books=Book::whereIn('id',$book_id)->get();
        return view('backend.book.rent-books',compact('books'));
    }

    public function returnBook($id)
    {
        $rent=Rent::findOrFail($id);
        $rent->state='2';
        $rent->return_date=Carbon::now();

        $rent->save();

        $book=Book::findOrFail($rent->book_id);
        $book->remain +=1;
        $book->save();

        return back()->with('success','Book returned successfully');
    }

    public function rentBookList($id)
    {
        $rents=Rent::where('user_id',$id)->get();
    }

    public function acceptRent($id)
    {
        $rent=Rent::find($id);
        $rent->state='1';
        $rent->update();
        return redirect()->back()->with('success','Rent accepted successfully');
    }

    public function userRent($id)
    {
        $pendings=Rent::where('user_id',$id)->where('state','0')->latest()->get();
        $notReturns=Rent::where('user_id',$id)->where('state','1')->latest()->get();
        $returns=Rent::where('user_id',$id)->where('state','2')->latest()->get();
        $class=Member::where('user_id',$id)->get()[0]->class;
        return view('backend.rent.user-rent',compact('pendings','notReturns','returns','class'));
    }

    public function banUser($id)
    {
        $user=User::find($id);
        $user->isBanned='1';
        $user->update();
        return redirect()->back();
    }

    public function restoreUser($id)
    {
        $user=User::find($id);
        $user->isBanned='0';
        $user->update();
        return redirect()->back();
    }
}

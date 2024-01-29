<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Opportunity;
use App\Models\Rent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addMember(Request $request)
    {
        try {
            $request->validate([
                "class" => "required",
            ]);
            $member = new Member();
            $member->name = Auth::guard('api')->user()->name;
            $member->phone = Auth::guard('api')->user()->phone;
            $member->user_id = Auth::guard('api')->user()->id;
            $member->class = $request->class;
            $member->save();
            return response()->json([
                'result' => 1,
                'message' => "We will check your member request and reply soon ...",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to send request!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function rentBook(Request $request)
    {
        try {
            $request->validate([
                "book_id" => "required",
            ]);
            $user_id = Auth::guard('api')->user()->id;
            $class=Member::where('user_id',$user_id)->get()[0]->class;
            if($class){
                $book=Opportunity::where('member_type',$class)->latest()->get()[0]->no_of_book;
            }
            else{
                $book=Opportunity::where('member_type','3')->latest()->get()[0]->no_of_book;
            }
            if(count($request->book_id)<=$book){
                foreach ($request->book_id as $b){
                    $price = Book::find($b)->price;

                    $rent = new Rent();
                    $overdue_date = $this->calculateEndDate($user_id);
                    $rent->user_id = $user_id;
                    $rent->book_id = $b;
                    $rent->start_date = now()->format('Y-m-d');
                    $rent->overdue_date = $overdue_date;

                    if (now()->gte($overdue_date)){
                        $rent->overdue_day = $this->calculateOverdueDay($overdue_date);
                    } else {
                        $rent->overdue_day = 0;
                    }
                    $rent->unit_price = $price;
                    $rent->save();

                    $book = Book::find($b);
                    $book->remain -= 1;
                    $book->update();
                }
                return response()->json([
                    'result' => 1,
                    'data' => $rent->refresh(),
                    'message' => "Renting book success",
                ], 201);
            }
            else{
                return response()->json([
                    'result' => 0,
                    'message' => 'Fail to rent book!',
                    'error' => "You exceed the limit you can rent.",
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'result' => 0,
                'message' => 'Fail to rent book!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

//calculate end date
    private function calculateEndDate($user_id)
    {
        $members = Member::pluck('user_id');
        if (count($members) > 0) {
            if (in_array((array)$user_id, (array)$members)) {
                $class = Member::where('user_id', $user_id)->pluck('class');
                if ($class[0] === '0') {
                    $duration = Opportunity::where('member_type', '0')->latest()->get()[0]->life_time;
                } elseif ($class[0] === '1') {
                    $duration = Opportunity::where('member_type', '1')->latest()->get()[0]->life_time;

                } elseif ($class[0] === '2') {
                    $duration = Opportunity::where('member_type', '2')->latest()->get()[0]->life_time;

                } else {
                    $duration = Opportunity::where('member_type', '3')->latest()->get()[0]->life_time;
                }
            }
        }
        else{
            $duration=Opportunity::where('member_type','3')->latest()->get()[0]->life_time;
        }
        $end_date = Carbon::now()->addDays($duration)->format('Y-m-d');
        return $end_date;
    }

    //calculate overdue day
    private function calculateOverdueDay($overdue_date)
    {
        $overdue_day= Carbon::now()->diffInDays($overdue_date, false);
        return abs($overdue_day);
    }
}

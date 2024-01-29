<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Opportunity::orderby('id', 'desc')->get();
        return view('backend.opportunities.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.opportunities.create');
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
            'member_type' => 'required',
            'no_of_book' => 'required',
            'life_time' => 'required',
            'overdue_price_per_day' => 'required',
            'overdue_price_per_week' => 'required',
            'overdue_price_per_month' => 'required',
        ]);
        $opportunity=new Opportunity();
        $opportunity->member_type=$request->member_type;
        $opportunity->no_of_book=$request->no_of_book;
        $opportunity->life_time=$request->life_time;
        $opportunity->overdue_price_per_day=$request->overdue_price_per_day;
        $opportunity->overdue_price_per_week=$request->overdue_price_per_week;
        $opportunity->overdue_price_per_month=$request->overdue_price_per_month;
        $opportunity->save();

        return to_route('opportunities.index')->with('success','Member Opportunity is set successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Opportunity::findOrFail($id);
        return view('backend.opportunities.edit', compact('data'));
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
            'member_type' => 'required',
            'no_of_book' => 'required',
            'life_time' => 'required',
            'overdue_price_per_day' => 'required',
            'overdue_price_per_week' => 'required',
            'overdue_price_per_month' => 'required',
        ]);
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->member_type=$request->member_type;
        $opportunity->no_of_book=$request->no_of_book;
        $opportunity->life_time=$request->life_time;
        $opportunity->overdue_price_per_day=$request->overdue_price_per_day;
        $opportunity->overdue_price_per_week=$request->overdue_price_per_week;
        $opportunity->overdue_price_per_month=$request->overdue_price_per_month;
        $opportunity->save();

        return to_route('opportunities.index')->with('success','Member Opportunity is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Opportunity::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Member Opportunity deleted successfully!');
    }
}

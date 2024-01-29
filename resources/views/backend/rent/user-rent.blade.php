@extends('layouts.app')

@section('user')
    collapsed active
@endsection
@section('user-show')
    show
@endsection
@section('user-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">User Rent Books</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">User Rent Books</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @include('partials.msg')
            <div class="row">
                <div class="col-lg-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pending</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Not Returned</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Returned</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <div class="card-body">
                                <div id="customerList">
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table text-center table-nowrap">
                                            <thead class="table-light">
                                            <tr>
                                                <th class="sort" >#</th>
                                                <th class="sort" >Book name</th>
                                                <th class="sort">Rent Date</th>
                                                <th class="sort">Overdue Date</th>
                                                <th>Overdue Day</th>
                                                <th>Unit Price</th>
                                                <th class="">Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                            @forelse($pendings as $i=>$ret)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        {{\App\Models\Book::find($ret->book_id)->title}}
                                                    </td>
                                                    <td>{{$ret->created_at->format('Y-m-d')}}</td>
                                                    <td class="">{{$ret->overdue_date}}</td>
                                                    <td>{{$ret->overdue_day}}</td>
                                                    <td>{{$ret->unit_price}}</td>
                                                    <td>
                                                        @if($ret->state === '0')
                                                            <i class="text-warning">Pending</i>
                                                        @else
                                                            @if($ret->status === '1')
                                                                <i class="text-danger">Not returned</i>
                                                            @else
                                                                <i class="text-success">Returned</i>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ret->status === '1')
                                                            <div class="d-flex justify-content-center gap-2">
                                                                @switch($ret->state)
                                                                    @case('0')
                                                                            <div class="show">
                                                                                <a class="btn btn-sm btn-warning show-item-btn" href="{{route('rent.accept',$ret->id)}}">Accept</a>
                                                                            </div>
                                                                        @break
                                                                    @case('1')
                                                                        <div class="show">
                                                                            <a class="btn btn-sm btn-danger show-item-btn" href="{{route('book.return',$ret->id)}}">Return</a>
                                                                        </div>
                                                                        @break
                                                                    @case('2')
                                                                        <div class="show">
                                                                            <a class="btn btn-sm btn-success show-item-btn" href="#">Complete</a>
                                                                        </div>
                                                                        @break
                                                                    @default

                                                                @endswitch
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center h3">There is no book !</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card -->
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <div class="card-body">
                                <div id="customerList">
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table align-middle table-nowrap">
                                            <thead class="table-light">
                                            <tr>
                                                <th class="sort" >#</th>
                                                <th class="sort" >Book name</th>
                                                <th class="sort">Rent Date</th>
                                                <th class="sort">Overdue Date</th>
                                                <th>Overdue Day</th>
                                                <th>Overdue Price</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th class="">Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                            @php
                                                $total=0;
                                            @endphp
                                            @forelse($notReturns as $i=>$ret)
                                                @php
                                                    $day=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_day;
                                                    $week=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_week;
                                                    $month=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_month;
                                                    $unitPrice=$ret->unit_price;
                                                    if($ret->overdue_day<7)
                                                        $totalOverdue=($day*$ret->overdue_day)+$unitPrice;
                                                    elseif($ret->overdue_day<14)
                                                        $totalOverdue=($week*1)+$unitPrice;
                                                    elseif($ret->overdue_day<21)
                                                        $totalOverdue=($week*2)+$unitPrice;
                                                    elseif($ret->overdue_day<28)
                                                        $totalOverdue=($week*3)+$unitPrice;
                                                    elseif($ret->overdue_day<31)
                                                        $totalOverdue=($week*4)+$unitPrice;
                                                    elseif($ret->overdue_day<61)
                                                        $totalOverdue=($month*1)+$unitPrice;
                                                    elseif($ret->overdue_day<91)
                                                        $totalOverdue=($month*2)+$unitPrice;
                                                    elseif($ret->overdue_day<121)
                                                        $totalOverdue=($month*3)+$unitPrice;
                                                $total+=$totalOverdue
                                                @endphp
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        {{\App\Models\Book::find($ret->book_id)->title}}
                                                    </td>
                                                    <td>{{$ret->created_at->format('Y-m-d')}}</td>
                                                    <td class="">{{$ret->overdue_date}}</td>
                                                    <td>{{$ret->overdue_day}}</td>

                                                    @if($ret->overdue_day<7)
                                                        <td>{{$day*$ret->overdue_day}}</td>
                                                    @elseif($ret->overdue_day<14)
                                                        <td>{{($week*1)}}</td>
                                                    @elseif($ret->overdue_day<21)
                                                        <td>{{($week*2)}}</td>
                                                    @elseif($ret->overdue_day<28)
                                                        <td>{{($week*3)}}</td>
                                                    @elseif($ret->overdue_day<31)
                                                        <td>{{($week*4)}}</td>
                                                    @elseif($ret->overdue_day<61)
                                                        <td>{{($month*1)}}</td>
                                                    @elseif($ret->overdue_day<91)
                                                        <td>{{($month*2)}}</td>
                                                    @elseif($ret->overdue_day<121)
                                                        <td>{{($month*3)}}</td>
                                                    @endif
                                                    <td>{{$unitPrice}}</td>

                                                    @if($ret->overdue_day<7)
                                                        <td>{{($day*$ret->overdue_day)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<14)
                                                        <td>{{($week*1)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<21)
                                                        <td>{{($week*2)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<28)
                                                        <td>{{($week*3)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<31)
                                                        <td>{{($week*4)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<61)
                                                        <td>{{($month*1)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<91)
                                                        <td>{{($month*2)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<121)
                                                        <td>{{($month*3)+$unitPrice}}</td>
                                                    @endif
                                                    <td>
                                                        @if($ret->state === '0')
                                                            <i class="text-warning">Pending</i>
                                                        @else
                                                            @if($ret->state === '1')
                                                                <i class="text-danger">Not returned</i>
                                                            @else
                                                                <i class="text-success">Returned</i>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ret->status === '1')
                                                            <div class="d-flex gap-2">
                                                                @if($ret->state==='0')
                                                                    <div class="show">
                                                                        <a class="btn btn-sm btn-success show-item-btn" href="{{route('rent.accept',$ret->id)}}">Accept</a>
                                                                    </div>
                                                                @else
                                                                    <div class="show">
                                                                        <a class="btn btn-sm btn-success show-item-btn" href="{{route('book.return',$ret->id)}}">Return</a>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center h3">There is no book !</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <th colspan="10" class="fw-bold text-end">Total : {{$total}}</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card -->
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                            <div class="card-body">
                                <div id="customerList">
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table text-center table-nowrap">
                                            <thead class="table-light">
                                            <tr>
                                                <th class="sort" >#</th>
                                                <th class="sort" >Book name</th>
                                                <th class="sort">Rent Date</th>
                                                <th class="sort">Overdue Date</th>
                                                <th>Overdue Day</th>
                                                <th>Overdue Price</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th>Return Date</th>
                                                <th class="">Status</th>
{{--                                                <th>Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                            @forelse($returns as $i=>$ret)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        {{\App\Models\Book::find($ret->book_id)->title}}
                                                    </td>
                                                    <td>{{$ret->created_at->format('Y-m-d')}}</td>
                                                    <td class="">{{$ret->overdue_date}}</td>
                                                    <td>{{$ret->overdue_day}}</td>
                                                    @php
                                                        $day=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_day;
                                                        $week=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_week;
                                                        $month=\App\Models\Opportunity::where('member_type',$class)->latest()->get()[0]->overdue_price_per_month;
                                                        $unitPrice=$ret->unit_price;
                                                        $totalOverdue=0;

                                                    @endphp
                                                    @if($ret->overdue_day<7)
                                                        <td>{{$day*$ret->overdue_day}}</td>
                                                    @elseif($ret->overdue_day<14)
                                                        <td>{{($week*1)}}</td>
                                                    @elseif($ret->overdue_day<21)
                                                        <td>{{($week*2)}}</td>
                                                    @elseif($ret->overdue_day<28)
                                                        <td>{{($week*3)}}</td>
                                                    @elseif($ret->overdue_day<31)
                                                        <td>{{($week*4)}}</td>
                                                    @elseif($ret->overdue_day<61)
                                                        <td>{{($month*1)}}</td>
                                                    @elseif($ret->overdue_day<91)
                                                        <td>{{($month*2)}}</td>
                                                    @elseif($ret->overdue_day<121)
                                                        <td>{{($month*3)}}</td>
                                                    @endif
                                                    <td>{{$unitPrice}}</td>

                                                    @if($ret->overdue_day<7)
                                                        <td>{{($day*$ret->overdue_day)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<14)
                                                        <td>{{($week*1)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<21)
                                                        <td>{{($week*2)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<28)
                                                        <td>{{($week*3)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<31)
                                                        <td>{{($week*4)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<61)
                                                        <td>{{($month*1)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<91)
                                                        <td>{{($month*2)+$unitPrice}}</td>
                                                    @elseif($ret->overdue_day<121)
                                                        <td>{{($month*3)+$unitPrice}}</td>
                                                    @endif
                                                    <td>{{$ret->return_date}}</td>
                                                    <td>
                                                        @if($ret->state === '0')
                                                            <i class="text-warning">Pending</i>
                                                        @else
                                                            @if($ret->state === '1')
                                                                <i class="text-danger">Not returned</i>
                                                            @else
                                                                <i class="text-success">Returned</i>
                                                            @endif
                                                        @endif
                                                    </td>
{{--                                                    <td>--}}
{{--                                                        @if($ret->status === '1')--}}
{{--                                                            <div class="d-flex gap-2">--}}
{{--                                                                @if($ret->state==='0')--}}
{{--                                                                    <div class="show">--}}
{{--                                                                        <a class="btn btn-sm btn-success show-item-btn" href="{{route('rent.accept',$ret->id)}}">Accept</a>--}}
{{--                                                                    </div>--}}
{{--                                                                @else--}}
{{--                                                                    <div class="show">--}}
{{--                                                                        <a class="btn btn-sm btn-success show-item-btn" href="{{route('book.return',$ret->id)}}">Return</a>--}}
{{--                                                                    </div>--}}
{{--                                                                @endif--}}

{{--                                                            </div>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center h3">There is no book !</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card -->
                        </div>
                    </div>

                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <script>
        $(function (){
            $('.toggle-status').change(function() {
                var status = $(this).prop('checked') == true ? '1' : '0';
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/rent-status',
                    data: {'status': status, 'id': id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
        // $(".table").dataTable({
        //     "order": [
        //         [0, "desc"]
        //     ]
        // });
        // $(".dataTables_length,.dataTables_filter,.dataTable,.dataTables_paginate,.dataTables_info").author().addClass(
        //     "px-0");
    </script>
@endsection



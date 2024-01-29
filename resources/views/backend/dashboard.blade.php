@extends('layouts.app')
@section('dash')
    collapsed active
@endsection
@section('dash')
    show
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col">

                    <div class="h-100">

                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p
                                                    class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Total Books</p>
                                            </div>
                                        </div>
                                        @php
                                            $books=\App\Models\Book::all()->sum('no_of_book');
                                        @endphp
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target="{{$books}}">0</span> books
                                                </h4>
                                                <a href="{{route('book.index')}}" class="text-decoration-underline">View all books</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                                            <i class="bx bx-book text-success"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p
                                                    class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    All Users</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target={{\App\Models\User::count()-1}}>0</span></h4>
                                                <a href="{{route('user.index')}}" class="text-decoration-underline">View all users</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="bx bx-group text-info"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p
                                                    class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Members</p>
                                            </div>

                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                        class="counter-value" data-target="{{\App\Models\Member::count()}}">0</span>
                                                </h4>
                                                <a href="{{route('members.index')}}" class="text-decoration-underline">See all members</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                                            <i class="bx bx-user-check text-warning"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Recent Renting</h4>

                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            @php
                                                // $rent=\App\Models\Rent::latest()->limit(5)->get();
                                                $data=\App\Models\Order::with(['user','region.delivery_fees','orderItems.book'])->orderby('id','desc')->latest()->limit(5)->get();
                                            @endphp
                                            {{-- <table
                                                class="table table-borderless table-centered text-center table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                <tr>
                                                    <th class="sort" >#</th>
                                                    <th class="sort" >Name</th>
                                                    <th class="sort" >Book name</th>
                                                    <th class="sort">Rent Date</th>
                                                    <th class="sort">Overdue Date</th>
                                                    <th>Overdue Day</th>
                                                    <th class="">Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                @forelse($rent as $i=>$ret)
                                                    <tr>
                                                        <td>{{$i+1}}</td>
                                                        <td>
                                                            {{ $ret->user?->name }}
                                                        </td>
                                                        <td>
                                                            {{ $ret->book?->title }}
                                                        </td>
                                                        <td>{{$ret->created_at->format('Y-m-d')}}</td>
                                                        <td class="">{{$ret->overdue_date}}</td>
                                                        <td>{{$ret->overdue_day}}</td>
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
                                                        <td colspan="8" class="text-center h3">There is no book !</td>
                                                    </tr>
                                                @endforelse
                                            </table><!-- end table --> --}}
                                            <table class="table text-center table-nowrap">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Books</th>
                                                    <th>Delivery Fees</th>
                                                    <th>Status</th>
                                                    <th>State</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    @forelse ($data as $i => $item)
                                                        <tr>
                                                            <td>{{ $i+1 }}</td>
                                                            <td>{{ $item->user->name }}</td>
                                                            <td>{{ $item->address }}</td>
                                                            <td>
                                                                @foreach ($item->orderItems as $value)
                                                                    {{ $value->book->code }},<br>
                                                                @endforeach

                                                            </td>
                                                            <td>{{ $item->delivery_fee }} Kyats</td>
                                                            <td>
                                                                @if ($item->status == 'pending')
                                                                    <div class="btn btn-sm rounded btn-warning">pending</div>
                                                                @else
                                                                    <div class="btn btn-sm rounded btn-success">success</div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @switch($item->state)
                                                                    @case('rented')
                                                                        <div class="btn btn-sm rounded btn-warning">rented</div>
                                                                        @break
                                                                    @case('overdue')
                                                                        <div class="btn btn-sm rounded btn-danger">overdue</div>
                                                                        @break
                                                                    @case('returned')
                                                                        <div class="btn btn-sm rounded btn-success">returned</div>
                                                                        @break
                                                                    @default
                                                                    <div class="btn btn-sm rounded btn-info">progressing</div>
                                                                @endswitch
                                                            </td>
                                                            <td>
                                                                <div class="edit">
                                                                    <a class="btn btn-sm btn-success edit-item-btn" href="{{route('rent.show',$item->id)}}"><i class="ri-edit-line"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center h3">There is no renting book !</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- .card-->
                            </div> <!-- .col-->
                        </div> <!-- end row-->

                    </div> <!-- end .h-100-->

                </div> <!-- end col -->

            </div>

        </div>
        <!-- container-fluid -->
    </div>
@endsection

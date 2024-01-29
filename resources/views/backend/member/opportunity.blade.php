@extends('layouts.app')

@section('opportunity')
    collapsed active
@endsection
@section('opportunity')
    show
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Opportunity</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Add Opportunity</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6">
                    <form action="{{route('opportunity.store')}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Add Opportunity</h5>
                            </div>
                            <div class="card-body">
                                <label for="">Member Type</label>
                                <select class="form-select" aria-label="Default select example" name="member_type">
                                    <option value="0">Three Months</option>
                                    <option value="1">Six Months</option>
                                    <option value="2">One Year</option>
                                    <option value="3">Normal</option>
                                </select>
                                <div class="form-group my-3">
                                    <label for="">Number of book</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('no_of_book') is-invalid @enderror" name="no_of_book" >
                                    @error('no_of_book')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Life Time</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('life_time') is-invalid @enderror" name="life_time" >
                                    @error('life_time')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Day</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_day') is-invalid @enderror" name="overdue_price_per_day" >
                                    @error('overdue_price_per_day')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Week</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_week') is-invalid @enderror" name="overdue_price_per_week" >
                                    @error('overdue_price_per_week')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Month</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_month') is-invalid @enderror" name="overdue_price_per_month" >
                                    @error('overdue_price_per_month')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <!-- end dropzon-preview -->
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Submit</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-gift-line me-2"></i>Opportunities</h5>
                        </div>
                        <div class="card-body">
                            <div id="customerList">
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th class="sort" >Member type</th>
                                            <th class="sort" >No: book</th>
                                            <th class="sort">Life time</th>
                                            <th class="sort">Overdue price/day</th>
                                            <th class="sort">Overdue price/week</th>
                                            <th class="sort">Overdue price/month</th>
                                            <th class="sort">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @php
                                            $opportunities=\App\Models\Opportunity::latest()->get();
                                        @endphp
                                        @forelse($opportunities as $i=>$opportunity)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>
                                                    @if($opportunity->member_type === '0')
                                                        3 Months
                                                    @elseif($opportunity->member_type === '1')
                                                        6 Months
                                                    @elseif($opportunity->member_type === '2')
                                                        1 year
                                                    @else
                                                        Normal
                                                    @endif
                                                </td>
                                                <td>{{$opportunity->no_of_book}}</td>
                                                <td class="">{{$opportunity->life_time}}</td>
                                                <td>{{$opportunity->overdue_price_per_day}}</td>
                                                <td>{{$opportunity->overdue_price_per_week}}</td>
                                                <td>{{$opportunity->overdue_price_per_month}}</td>
                                                <td>{{$opportunity->created_at->format('Y-m-d')}}</td>
                                                {{--<td>--}}
                                                {{--    <div class="d-flex gap-2">--}}
                                                {{--        <div class="show">--}}
                                                {{--            <a class="btn btn-sm btn-info show-item-btn" href=""><i class="ri-eye-line"></i></a>--}}
                                                {{--        </div>--}}
                                                {{--    </div>--}}
                                                {{--</td>--}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center h3">There is no opportunity !</td>
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
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection


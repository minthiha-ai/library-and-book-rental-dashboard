@extends('layouts.app')


@section('opportunity')
    collapsed active
@endsection
@section('opportunity-show')
    show
@endsection
@section('opportunity-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Opportunity</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Member Opportunity</li>
                                <li class="breadcrumb-item active">Edit Opportunity</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('opportunities.update', $data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Add Opportunity</h5>
                            </div>
                            <div class="card-body">
                                <label for="">Member Type</label>
                                <select class="form-select" aria-label="Default select example" name="member_type">
                                    <option value="0" {{ ($data->member_type == "0") ? 'selected' : ''  }}>Three Months</option>
                                    <option value="1" {{ ($data->member_type == "1") ? 'selected' : ''  }}>Six Months</option>
                                    <option value="2" {{ ($data->member_type == "2") ? 'selected' : ''  }}>One Year</option>
                                    <option value="3" {{ ($data->member_type == "3") ? 'selected' : ''  }}>Normal</option>
                                </select>
                                <div class="form-group my-3">
                                    <label for="">Number of book</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('no_of_book') is-invalid @enderror" name="no_of_book" value="{{ $data->no_of_book }}" >
                                    @error('no_of_book')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Life Time</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('life_time') is-invalid @enderror" name="life_time" value="{{ $data->life_time }}">
                                    @error('life_time')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Day</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_day') is-invalid @enderror" name="overdue_price_per_day" value="{{ $data->overdue_price_per_day }}">
                                    @error('overdue_price_per_day')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Week</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_week') is-invalid @enderror" name="overdue_price_per_week" value="{{ $data->overdue_price_per_week }}">
                                    @error('overdue_price_per_week')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Overdue Price Per Month</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('overdue_price_per_month') is-invalid @enderror" name="overdue_price_per_month" value="{{ $data->overdue_price_per_month }}">
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

                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection


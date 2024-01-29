@extends('layouts.app')

@section('point')
    collapsed active
@endsection
@section('point-show')
    show
@endsection
@section('add-point-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Update Credit Point</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('credit-points.index')}}">Credit Point</a></li>
                                <li class="breadcrumb-item active">Update Credit Point</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('credit-points.update',$data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Update Credit Point</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="point">Point</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('point') is-invalid @enderror" name="point" value="{{ $data->point }}">
                                    @error('point')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('price') is-invalid @enderror" name="price" value="{{ $data->price }}">
                                    @error('price')
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


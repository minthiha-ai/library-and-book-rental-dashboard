@extends('layouts.app')

@section('region')
    collapsed active
@endsection
@section('region-show')
    show
@endsection
@section('add-region-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Region</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('regions.index')}}">Regions</a></li>
                                <li class="breadcrumb-item active">Add Region</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('regions.store')}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Add Region</h5>
                            </div>
                            <div class="card-body">

                                <div class="form-group my-3">
                                    <label for="employeeName" class="form-label mb-3">တိုင်း နှင့် ပြည်နယ်</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" name="name" placeholder="Eg. region .....">
                                    @error('name')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <input class="form-check-input @error('cod') is-invalid @enderror" name="cod" type="checkbox" role="switch" id="flexSwitchCheckChecked" value="1" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Cash On Delivery</label>
                                    @error('cod')
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




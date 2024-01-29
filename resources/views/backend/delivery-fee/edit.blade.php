@extends('layouts.app')

@section('delivery-fee')
    collapsed active
@endsection
@section('delivery-fee-show')
    show
@endsection
@section('add-delivery-fee-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Update Delivery Fee</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('delivery-fees.index')}}">Delivery Fees</a></li>
                                <li class="breadcrumb-item active">Update Delivery Fee</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('delivery-fees.update', $data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Update Delivery Fee</h5>
                            </div>
                            <div class="card-body">

                                <div class="form-group my-3">
                                    <label for="employeeName" class="form-label mb-3">တိုင်း နှင့် ပြည်နယ်</label>
                                    <select name="region_id" class="form-control select2  @error('region_id') is-invalid @enderror" id="">
                                        <option disabled>--- Select Region ---</option>
                                        @foreach ($regions as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $data->region_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="" class="form-label mb-3">မြို့</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $data->city }}" placeholder="">
                                    @error('city')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="" class="form-label mb-3">ကျသင့်ငွေ</label>
                                    <input type="text" class="form-control @error('fee') is-invalid @enderror" name="fee" value="{{ $data->fee }}" placeholder="">
                                    @error('fee')
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

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection


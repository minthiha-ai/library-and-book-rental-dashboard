@extends('layouts.app')


@section('package')
    collapsed active
@endsection
@section('package-show')
    show
@endsection
@section('package-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Package</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Subscription Package</li>
                                <li class="breadcrumb-item active">Edit Package</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('packages.update', $data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Edit Package</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">Package Title</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror" name="title" value="{{ $data->title }}">
                                    @error('title')
                                        <small class="invalid-feedback font-weight-bold" role="alert">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Package Duration <span class=" text-muted">(*Please Enter Duration with days)</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('package_duration') is-invalid @enderror" name="package_duration" value="{{ $data->package_duration }}">
                                    @error('package_duration')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Number of Books</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('book_per_rent') is-invalid @enderror" name="book_per_rent" value="{{ $data->book_per_rent }}">
                                    @error('book_per_rent')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Rent Duration <span class=" text-muted">(*Please Enter Duration with days)</span></label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('rent_duration') is-invalid @enderror" name="rent_duration" value="{{ $data->rent_duration }}">
                                    @error('rent_duration')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Package Price</label>
                                    <input type="number" class="form-control form-control-lg rounded-3 @error('price') is-invalid @enderror" name="price" value="{{ $data->price }}">
                                    @error('price')
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
                                <div class="form-group my-4">
                                    <label for="">Package Image</label>
                                    <div class="input-images"></div>
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

        let image = "{{ $data->image }}";
        let path = "{{ asset('storage/images/package/') }}";
        let preloaded = [{
            id: image,
            src: path+"/"+image,
        }];
        $('.input-images').imageUploader({
            preloaded: preloaded,
            extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

            mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

            maxFiles: 1,

            imagesInputName: 'image',
        });
    });
</script>
@endsection

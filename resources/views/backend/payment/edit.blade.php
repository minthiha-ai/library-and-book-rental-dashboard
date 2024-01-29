@extends('layouts.app')

@section('payment')
    collapsed active
@endsection
@section('payment-show')
    show
@endsection
@section('add-payment-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Update Payment</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('payments.index')}}">Payments</a></li>
                                <li class="breadcrumb-item active">Update Payment</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('payments.update', $data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Add Payment</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="employeeName" class="form-label mb-3">အမျိုးအစား / Payment Type</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('payment_type') is-invalid @enderror" name="payment_type" value="{{ $data->payment_type }}"  placeholder="Eg. KPay">
                                    @error('payment_type')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="employeeName" class="form-label mb-3">နာမည်</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ $data->name }}">
                                    @error('name')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="employeeName" class="form-label mb-3">Payment နံပါတ်</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('number') is-invalid @enderror" name="number" value="{{ $data->number }}">
                                    @error('number')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Payment Photo</label>
                                    <div class="input-images"></div>
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Qr Code</label>
                                    <div class="input-qr"></div>
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

            let image = "{{ $data->payment_logo }}";
            let path = "{{ asset('storage/images/payment/') }}";
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

            let qrImage = "{{ $data->qr }}";
            let preloadedQR = [{
                id: qrImage,
                src: path+"/"+qrImage,
            }];
            $('.input-qr').imageUploader({
                preloaded: preloadedQR,
                extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

                mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

                maxFiles: 3,

                imagesInputName: 'qr_image',
            });
        });
    </script>
@endsection


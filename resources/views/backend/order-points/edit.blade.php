@extends('layouts.app')

@section('point')
    collapsed active
@endsection
@section('point-show')
    show
@endsection
@section('order-point-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Accept Order</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('order-points.index')}}">Credit Point Order</a></li>
                                <li class="breadcrumb-item active">Accept Order</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('order-points.update',$data->id) }}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-edit-line me-2"></i>Accept Order</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group my-4">
                                            <label for="">Credit Points</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{ $data->credit_point->point }} @if ($data->credit_point->point == 1) point @else points @endif">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Price</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->credit_point->price}} Kyats">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group my-4">
                                            <label for="">Name</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->user?->name}}">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Email</label>
                                            <input type="email" disabled class="form-control rounded-3" name="name" value="{{$data->user?->email}}">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Payment name</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->payment?->name}}">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Payment Type</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->payment?->payment_type}}">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Status</label>
                                            <select name="status" class="form-control select2">
                                                <option value="0">pending</option>
                                                <option value="1">complete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group my-4">
                                            <label for="">Payment Photo</label><br>
                                            @if ($data->payment_photo != '')
                                                <img src="{{asset('storage/images/payment/'.$data->payment_photo)}}" alt="" class="img img-fluid">
                                            @else
                                                <img src="{{asset('images/logo.png')}}" alt="" class="img img-fluid">
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="text-end mb-3">
                                    <a href="{{ route('order-points.index') }}" class="btn btn-warning w-sm">Back</a>
                                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                                </div>
                            </div>
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
        function previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                    $("#previewImg").removeClass("d-none");
                    $("#cover").hide();
                    $("#edit").removeClass("d-none");
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

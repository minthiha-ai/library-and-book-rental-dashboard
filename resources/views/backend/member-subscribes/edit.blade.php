@extends('layouts.app')

@section('member')
    collapsed active
@endsection
@section('member-show')
    show
@endsection
@section('subscribe-member-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Accept Subscription</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('subscribe.index')}}">Member Subscriptions</a></li>
                                <li class="breadcrumb-item active">Accept Subscription</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('subscribe.update',$data->id) }}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-edit-line me-2"></i>Accept Subscription</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group my-4">
                                            <label for="">Package</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->package?->title}}">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Package Duration</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->package?->package_duration}} Days">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Book per rent</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->package?->book_per_rent}} Books">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Rent Duration</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->package?->rent_duration}} Days">
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Package Price</label>
                                            <input type="text" disabled class="form-control rounded-3" name="name" value="{{$data->package?->price}} Kyats">
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
                                    <a href="{{ route('subscribe.index') }}" class="btn btn-warning w-sm">Back</a>
                                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    {{-- <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Package Subscription</h1>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-start">
                                                    <span>Username</span>
                                                    <span>{{$data->user?->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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

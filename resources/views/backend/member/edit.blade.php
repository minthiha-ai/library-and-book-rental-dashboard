@extends('layouts.app')

@section('member')
    collapsed active
@endsection
@section('member-show')
    show
@endsection
@section('member-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Member</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('members.index')}}">Member</a></li>
                                <li class="breadcrumb-item active">Edit Member</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('members.update',$member->id) }}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-edit-line me-2"></i>Edit Member</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group my-4">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->name}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Phone</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->phone}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">User Code</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->userCode->user_code}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Member Code</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->userCode->member_code}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Points</label>
                                            <input type="text" class="form-control rounded-3 @error('point') is-invalid @enderror" name="point" value="{{$member->userPoint?->point}}">
                                            @error('point')
                                                <small class="invalid-feedback font-weight-bold" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group my-4">
                                            <label for="">Package</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->title}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Package Duration</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->package_duration}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Book Per Rent</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->book_per_rent}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Rent Duration</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->rent_duration}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Price</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->price}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Overdue Price per Day</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->overdue_price_per_day}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Overdue Price per Week</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->overdue_price_per_week}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Overdue Price per Month</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->overdue_price_per_month}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="">Start Date</label>
                                            <input type="text" class="form-control rounded-3" value="{{$member->packages[0]->pivot->created_at}}" disabled>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="id_start_datetime">Exprie Date</label>
                                            <div class="input-group date" id="dateTime">
                                                <input type="text" class="form-control rounded-3 @error('expire_date') is-invalid @enderror" name="exprie_date" value="{{ $member->packages[0]->pivot->expire_date ?? $member->packages[0]->pivot->updated_at->copy()->addDays($member->packages[0]->package_duration) }}" class="form-control" required/>
                                                @error('exprie_date')
                                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

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
        (function($){
            $(function(){
                $('#dateTime').datetimepicker({
                    "allowInputToggle": true,
                    "showClose": true,
                    "showClear": true,
                    "showTodayButton": true,
                    "format": "YYYY-MM-DD HH:mm:ss",
                });
            });
        })(jQuery);
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

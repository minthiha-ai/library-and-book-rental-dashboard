@extends('layouts.app')

@section('user')
    collapsed active
@endsection
@section('user-show')
    show
@endsection
@section('user-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">User Detail</h4>
                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></li>
                                <li class="breadcrumb-item active">{{$user->name}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section('script')
    <script>
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

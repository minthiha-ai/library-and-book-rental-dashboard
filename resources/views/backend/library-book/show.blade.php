@extends('layouts.app')

@section('library-book')
    collapsed active
@endsection
@section('library-book-show')
    show
@endsection
@section('add-library-book-active')
    active
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Book Detail</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('library-book.index')}}">Book</a></li>
                                <li class="breadcrumb-item active">{{$libraryBook->title}}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12 mb-5">
                    <img src="{{asset('storage/library-book/cover//'.$libraryBook->cover)}}" alt="" class="w-25">
                </div>
                <div class="mb-4 col-4 fw-bold h5">
                    Title
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$libraryBook->title}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Category
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$libraryBook->category}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Author
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$libraryBook->author}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Number of book
                </div>
                <div class="mb-3 col-1">:</div>
                <div class="mb-3 col-6 h5">{{$libraryBook->no_of_book}}</div>
                <div class="mb-3 col-4 fw-bold h5">
                    Price
                </div>
                <div class="mb-3 col-1">:</div>
                <div class="mb-3 col-6 h5">{{$libraryBook->price}}</div>
                <!-- end col -->
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

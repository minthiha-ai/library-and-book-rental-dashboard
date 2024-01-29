@extends('layouts.app')

@section('book')
    collapsed active
@endsection
@section('book-show')
    show
@endsection
@section('add-book-active')
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
                                <li class="breadcrumb-item"><a href="{{route('book.index')}}">Book</a></li>
                                <li class="breadcrumb-item active">{{$book->title}}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12 mb-5">
                    <img src="{{asset('storage/images/cover/'.$book->cover)}}" alt="" class="w-25">
                </div>
                <div class="mb-4 col-4 fw-bold h5">
                    Book ID
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$book->code}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Title
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$book->title}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Category
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$book->category->name}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Genres
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">
                    @foreach($book->genres as $genre)
                        {{ $genre->name }},
                    @endforeach
                </div>
                <div class="mb-4 col-4 fw-bold h5">
                    Author
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$book->author}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Description
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5 text-justify">{!! $book->description !!}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Number of book
                </div>
                <div class="mb-4 col-1">:</div>
                <div class="mb-4 col-6 h5">{{$book->no_of_book}}</div>
                <div class="mb-4 col-4 fw-bold h5">
                    Credit Point
                </div>
                <div class="mb-3 col-1">:</div>
                <div class="mb-3 col-6 h5">{{$book->credit_point}}</div>
                @if($book->status === '0')
                    <div class="mb-3 col-4 fw-bold h5">
                        Status
                    </div>
                    <div class="mb-3 col-1">:</div>
                    <div class="mb-3 col-6 h5">New Arrival</div>
                @endif

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

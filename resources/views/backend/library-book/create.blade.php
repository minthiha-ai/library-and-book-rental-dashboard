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
                        <h4 class="mb-sm-0">Add Book</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('library-book.index')}}">Book</a></li>
                                <li class="breadcrumb-item active">Add Book</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-8">
                    <form action="{{route('library-book.store')}}" method="post" enctype="multipart/form-data" id="library-bookForm">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-library-book-open-line me-2"></i>Add Book</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-4">
                                    <label for="">Book Title</label>
                                    <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
                                    @error('title')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div>
                                    <label for="">Choose Category</label>
                                    <select class="form-select" aria-label="Default select example @error('category') is-invalid @enderror" name="category">
                                        @foreach($categories as $i=>$category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Author Name</label>
                                    <input type="text" class="form-control rounded-3 @error('author') is-invalid @enderror" name="author">
                                    @error('author')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Book Cover</label>
                                    <input type="file" id="cover" onchange="previewFile(this);" name="cover"
                                           class="form-control p-1 mr-2 overflow-hidden @error('cover') is-invalid @enderror">
                                    @error('cover')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                    <a id="edit" onclick="$('#cover').trigger('click');"
                                       class="btn d-none text-white btn-primary btn-sm" style="position:absolute; right: 22px;">
                                        <i class="ri-edit-box-line "></i>
                                    </a>
                                    <img id="previewImg" onclick="$('#cover').trigger('click');" class="w-100 d-none rounded"
                                         src="" alt="your image" />
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Number of book</label>
                                    <input type="number" class="form-control rounded-3 @error('noOfBook') is-invalid @enderror" name="noOfBook">
                                    @error('noOfBook')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Book Price</label>
                                    <input type="number" class="form-control rounded-3 @error('price') is-invalid @enderror" name="price">
                                    @error('price')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
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

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
                        <h4 class="mb-sm-0">Add Book</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('book.index')}}">Book</a></li>
                                <li class="breadcrumb-item active">Add Book</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('book.store')}}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-book-open-line me-2"></i>Add Book</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-4">
                                    <label for="">Book ID</label>
                                    <input type="text" class="form-control rounded-3 @error('book_id') is-invalid @enderror" name="book_id" value="{{ old('book_id') }}">
                                    @error('book_id')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
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
                                    <select class="form-control select2" aria-label="Default select example @error('category') is-invalid @enderror" name="category">
                                        @foreach($categories as $i=>$category)
                                            <option value="{{$category->id}}">
                                                {{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div>
                                    <label for="">Choose Genres</label>
                                    <select class="form-control select2" aria-label="Default select example @error('genre[]') is-invalid @enderror" name="genre[]" multiple>
                                        @foreach($genres as $i=>$item)
                                            <option value="{{$item->id}}">
                                                {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('genre')
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
                                    <label for="">Credit Point</label>
                                    <input type="text" class="form-control rounded-3 @error('credit_point') is-invalid @enderror" name="credit_point">
                                    @error('credit_point')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Book Cover</label>
                                    <div class="input-images"></div>
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Description</label>
                                    <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" name="description"cols="30" rows="10"></textarea>
                                    @error('description')
                                        <small class="invalid-feedback font-weight-bold" role="alert">
                                            {{ $message }}
                                        </small>
                                    @enderror
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

            $('.input-images').imageUploader({
                extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

                mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

                maxFiles: 3,

                imagesInputName: 'cover',
            });
        });
    </script>
@endsection

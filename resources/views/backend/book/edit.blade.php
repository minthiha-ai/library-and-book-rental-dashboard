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
                        <h4 class="mb-sm-0">Edit Book</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('book.index')}}">Book</a></li>
                                <li class="breadcrumb-item active">Edit Book</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('book.update',$book->id)}}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-edit-line me-2"></i>Edit Book</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-4">
                                    <label for="">Book ID</label>
                                    <input type="text" class="form-control rounded-3 @error('book_id') is-invalid @enderror" name="book_id" value="{{$book->code}}">
                                    @error('book_id')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Book Title</label>
                                    <input type="text" class="form-control rounded-3 @error('title') is-invalid @enderror" name="title" value="{{$book->title}}">
                                    @error('title')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Choose Category</label>
                                    <select class="form-control select2" aria-label="Default select example @error('category') is-invalid @enderror" name="category">
                                        @foreach($categories as $i=>$category)
                                            <option value="{{$category->id}}" @if ($category->id == $book->category_id) selected @endif>
                                                {{$category->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Choose Genres</label>
                                    <select class="form-control select2" aria-label="Default select example @error('genre[]') is-invalid @enderror" name="genre[]" multiple>
                                        @foreach($genres as $i=>$item)
                                            <option value="{{$item->id}}" @if(in_array($item->id, $book->genres->pluck('id')->toArray())) selected @endif>
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
                                    <input type="text" class="form-control rounded-3 @error('author') is-invalid @enderror" name="author" value="{{$book->author}}">
                                    @error('author')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Credit Point</label>
                                    <input type="text" class="form-control rounded-3 @error('credit_point') is-invalid @enderror" name="credit_point" value="{{$book->credit_point}}">
                                    @error('credit_point')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Book Cover
                                    </label>
                                    <div class="input-images"></div>
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Description</label>
                                    <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" name="description"cols="30" rows="10">{!! $book->description !!}</textarea>
                                    @error('description')
                                        <small class="invalid-feedback font-weight-bold" role="alert">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Number of books</label>
                                    <input type="number" class="form-control rounded-3 @error('noOfBook') is-invalid @enderror" name="noOfBook" value="{{$book->no_of_book}}">
                                    @error('noOfBook')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-4">
                                    <label for="">Remaining books</label>
                                    <input type="number" class="form-control rounded-3 @error('remain') is-invalid @enderror" name="remain" value="{{$book->remain}}">
                                    @error('remain')
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

            let image = "{{ $book->cover }}";
            let path = "{{ asset('storage/images/cover/') }}";
            let preloaded = [{
                id: image,
                src: path+"/"+image,
            }];
            $('.input-images').imageUploader({
                preloaded: preloaded,
                extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

                mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

                maxFiles: 1,

                imagesInputName: 'cover',
            });
        });
    </script>
@endsection

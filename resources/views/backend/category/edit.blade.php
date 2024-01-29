@extends('layouts.app')

@section('category')
    collapsed active
@endsection
@section('category-show')
    show
@endsection
@section('add-category-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

        <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Category</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('category.index')}}">Category</a></li>
                                <li class="breadcrumb-item active">Edit Category</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('category.update',$category->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Edit Category</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" name="name" value="{{$category->name}}" >
                                    @error('name')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <!-- end dropzon-preview -->
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Update</button>
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


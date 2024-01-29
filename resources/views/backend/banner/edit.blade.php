@extends('layouts.app')

@section('banner')
    collapsed active
@endsection
@section('banner-show')
    show
@endsection
@section('add-banner-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

        <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Banner</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('banner.index')}}">Banner</a></li>
                                <li class="breadcrumb-item active">Edit Banner</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('banner.update',$data->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Edit Banner</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror" name="title" value="{{$data->title}}" >
                                    @error('title')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Banner Image</label>
                                    <div class="input-images"></div>
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

@section('script')
    <script>
        $(document).ready(function() {

            let image = "{{ $data->image }}";
            let path = "{{ asset('storage/images/banner/') }}";
            let preloaded = [{
                id: image,
                src: path+"/"+image,
            }];
            $('.input-images').imageUploader({
                preloaded: preloaded,
                extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

                mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

                maxFiles: 1,

                imagesInputName: 'image',
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('event')
    collapsed active
@endsection
@section('event-show')
    show
@endsection
@section('add-event-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add Event</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('events.index')}}">Event</a></li>
                                <li class="breadcrumb-item active">Add Event</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('events.store')}}" method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-stack-line me-2"></i>Add Event</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">Event Title</label>
                                    <input type="text" class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror" name="title" >
                                    @error('title')
                                    <small class="invalid-feedback font-weight-bold" role="alert">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Event Description</label>
                                    <textarea class="form-control form-control-lg rounded-3" name="description" rows="10"></textarea>
                                </div>
                                <div class="form-group my-3">
                                    <label for="">Event Image</label>
                                    <div class="input-images"></div>
                                </div>
                                <!-- end dropzon-preview -->
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

            $('.input-images').imageUploader({
                extensions: ['.jpg','.jpeg','.png','.gif','.svg'],

                mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],

                maxFiles: 3,

                imagesInputName: 'image',
            });
        });
    </script>
@endsection


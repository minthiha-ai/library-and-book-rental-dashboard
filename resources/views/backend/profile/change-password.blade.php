@extends('layouts.app')

@section('style')
    <!-- dropzone css -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/libs/dropzone/dropzone.css')}}" type="text/css" />

    <!-- Filepond css -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/libs/filepond/filepond.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('dashboard/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Change Password</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-10">
                    <div class="card p-4">
                        <form action="{{ route('update-password') }}" method="get">
                            <div class="form-group">
                                <label for="title">Old Password</label>
                                <input type="password" class="form-control @error('old') is-invalid @enderror" name="old"
                                       id="old" placeholder="Enter old password">
                                @error('old')
                                <small class="invalid-feedback font-weight-bold" role="alert">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="title">New Password</label>
                                <input type="password" class="form-control @error('new') is-invalid @enderror" name="new"
                                       id="new" placeholder="Enter new password">
                                @error('new')
                                <small class="invalid-feedback font-weight-bold" role="alert">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="title">Re-Enter New Password</label>
                                <input type="password" class="form-control @error('reenter') is-invalid @enderror" name="reenter"
                                       id="reenter" placeholder="Re-Enter new password">
                                @error('old')
                                <small class="invalid-feedback font-weight-bold" role="alert">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload mr-1"></i> Update
                                Category</button>
                        </form>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection


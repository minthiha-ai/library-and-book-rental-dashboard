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
                        <h4 class="mb-sm-0">Users</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @include('partials.msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="customerList">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-4">
                                        <div id="customerList">
                                            <form action="{{ route('user.index') }}" method="get">
                                                <div class="d-flex">
                                                    <input type="text" class="form-control " name="search" placeholder="Search User">
                                                    <button class="btn btn-primary ml-2" type="submit"><i class="ri-search-line"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >User ID</th>
                                            <th class="sort" >Name</th>
                                            <th class="sort" >Phone</th>
                                            <th class="sort">Member</th>
                                            <th class="sort">Date</th>
                                            <th class="sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($users as $i=>$user)
                                            <tr>
                                                <td>
                                                    {{ $user->userCode->user_code }}
                                                </td>
                                                <td>
                                                    {{$user->name}}
                                                </td>
                                                <td>{{$user->phone}}</td>
                                                <td class="fw-bold text-success">
                                                    @if($user->member_status == '1')
                                                        yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>{{$user->created_at->format('Y-m-d')}}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        @if($user->isBanned==1)
                                                            <div class="remove">
                                                                <button type="button" onclick="return restoreConfirm({{$user->id}})" class="btn btn-sm btn-warning remove-item-btn">Restore</button>
                                                            </div>
                                                            <form action="{{ route('restore.user',$user->id)}}" class="d-none restoreForm{{$user->id}}" method="get">
                                                                @csrf
                                                            </form>
                                                        @else
                                                            <div class="remove">
                                                                <button type="button" onclick="return banConfirm({{$user->id}})" class="btn btn-sm btn-danger remove-item-btn">Ban</button>
                                                            </div>
                                                            <form action="{{ route('ban.user',$user->id)}}" class="d-none banForm{{$user->id}}" method="get">
                                                                @csrf
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center h3">There is no user !</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <script>

        const banConfirm=(id)=>{
            Swal.fire({html:'<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Are you Sure ?</h4><p class="text-muted mx-4 mb-0">Are you Sure You want to Ban this user?</p></div></div>',showCancelButton:!0,confirmButtonClass:"btn btn-primary w-xs me-2 mb-1",confirmButtonText:"Yes!",cancelButtonClass:"btn btn-danger w-xs mb-1",buttonsStyling:!1,showCloseButton:!0})
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            `User is banned successfully `,
                            'success'
                        )
                        setTimeout(function(){
                            $('.banForm'+id).submit();
                        },1000)
                    }
                })
        }
        const restoreConfirm=(id)=>{
            Swal.fire({html:'<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Are you Sure ?</h4><p class="text-muted mx-4 mb-0">Are you Sure You want to Restore this user ?</p></div></div>',showCancelButton:!0,confirmButtonClass:"btn btn-primary w-xs me-2 mb-1",confirmButtonText:"Yes, Restore It!",cancelButtonClass:"btn btn-danger w-xs mb-1",buttonsStyling:!1,showCloseButton:!0})
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Restored!',
                            `User is restored successfully `,
                            'success'
                        )
                        setTimeout(function(){
                            $('.restoreForm'+id).submit();
                        },1000)
                    }
                })
        }
        $(function (){
            $('.toggle-status').change(function() {
                var status = $(this).prop('checked') == true ? '1' : '0';
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/user-status',
                    data: {'status': status, 'id': id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
        $(".table").dataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $(".dataTables_length,.dataTables_filter,.dataTable,.dataTables_paginate,.dataTables_info").author().addClass(
            "px-0");

    </script>
@endsection



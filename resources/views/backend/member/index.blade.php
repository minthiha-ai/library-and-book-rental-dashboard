@extends('layouts.app')

@section('member')
    collapsed active
@endsection
@section('member-show')
    show
@endsection
@section('member-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Members</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Members</li>
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
                            <div class="row d-flex justify-content-end">
                                <div class="col-4">
                                    <div id="customerList">
                                        <form action="{{ route('members.index') }}" method="get">
                                            <div class="d-flex">
                                                <input type="text" class="form-control " name="search" placeholder="Search Member">
                                                <button class="btn btn-primary ml-2" type="submit"><i class="ri-search-line"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th>Member ID</th>
                                            <th class="sort" >Name</th>
                                            <th class="sort" >Phone</th>
                                            <th class="sort">Package</th>
                                            <th class="sort">Points</th>
                                            <th class="sort">Start Date</th>
                                            <th class="sort">Expire Date</th>
                                            <th class="sort">Remain Days</th>
                                            <th>Rent History</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($members as $i=>$member)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>
                                                    {{ $member->userCode->member_code }}
                                                </td>
                                                <td>
                                                    {{$member->name}}
                                                </td>
                                                <td>{{$member->phone}}</td>
                                                <td class="fw-bold text-warning">
                                                    @foreach ($member->packages as $item)
                                                        {{ $item->title }}
                                                    @endforeach
                                                </td>
                                                <td>{{ ($member->userPoint?->point == null) ? '0' : $member->userPoint?->point }} {{($member->userPoint?->point == 1 || $member->userPoint?->point == 0) ? 'point' : 'points' }}</td>
                                                <td>
                                                    <span class=" text-success">
                                                        {{$member->updated_at->format('Y-m-d')}}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class=" text-danger">
                                                        @foreach ($member->packages as $item)
                                                            {{ Carbon\Carbon::parse($item->pivot->expire_date ?? $item->pivot->updated_at->copy()->addDays($item->package_duration))->format('Y-m-d') }}
                                                            {{-- {{ Carbon\Carbon::parse($member->packages[0]->pivot->expire_date ?? $member->packages[0]->pivot->updated_at->copy()->addDays($member->packages[0]->package_duration))->format('Y-m-d') }} --}}
                                                        @endforeach
                                                    </span>
                                                </td>
                                                <td>

                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-sm btn-secondary edit-item-btn" href="{{route('members.show',$member->id)}}"><i class="ri-eye-line"></i></a>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                            <a class="btn btn-sm btn-success edit-item-btn" href="{{route('members.edit',$member->id)}}"><i class="ri-edit-line"></i></a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" onclick="return deleteConfirm({{$member->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            {{-- @if(\App\Models\User::find($member->user_id)) --}}
                                                                @if($member->isBanned==1)
                                                                    <div class="remove">
                                                                        <button type="button" onclick="return restoreConfirm({{$member->id}})" class="btn btn-sm btn-warning remove-item-btn"><i class="ri-lock-unlock-line"></i></button>
                                                                    </div>
                                                                    <form action="{{ route('restore.user',$member->id)}}" class="d-none restoreForm{{$member->id}}" method="get">
                                                                        @csrf
                                                                    </form>
                                                                @else
                                                                    <div class="remove">
                                                                        <button type="button" onclick="return banConfirm({{$member->id}})" class="btn btn-sm btn-dark remove-item-btn"><i class="ri-lock-line"></i></button>
                                                                    </div>
                                                                    <form action="{{ route('ban.user',$member->id)}}" class="d-none banForm{{$member->id}}" method="get">
                                                                        @csrf
                                                                    </form>
                                                                @endif
                                                            {{-- @endif --}}
                                                        </div>
                                                        <form action="{{ route('members.destroy',$member->id)}}" class="d-none deleteForm{{$member->id}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center h3">There is no member !</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{ $members->links('pagination::bootstrap-4') }}
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
                            'Banned!',
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
        const deleteConfirm=(id)=>{
            Swal.fire({html:'<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Are you Sure ?</h4><p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this ?</p></div></div>',showCancelButton:!0,confirmButtonClass:"btn btn-primary w-xs me-2 mb-1",confirmButtonText:"Yes, Delete It!",cancelButtonClass:"btn btn-danger w-xs mb-1",buttonsStyling:!1,showCloseButton:!0})
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            `Data is deleted successfully `,
                            'success'
                        )
                        setTimeout(function(){
                            $('.deleteForm'+id).submit();
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
                    url: '/member-status',
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



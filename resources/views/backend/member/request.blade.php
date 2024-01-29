@extends('layouts.app')

@section('member')
    collapsed active
@endsection
@section('member-show')
    show
@endsection
@section('request-member-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Member Request</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Member Request</li>
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
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th class="sort" >Name</th>
                                            <th class="sort" >Phone</th>
                                            <th class="sort">Class</th>
                                            <th class="sort">No: Book</th>
                                            <th class="sort">Action</th>
                                            <th class="sort">Date</th>
                                            {{--                                            <th class="sort">Action</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($members as $i=>$member)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>
                                                    {{$member->name}}
                                                </td>
                                                <td>{{$member->phone}}</td>
                                                <td class="fw-bold text-warning">
                                                    @if($member->class === '0')
                                                        3 Months
                                                    @elseif($member->class==='1')
                                                        6 Months
                                                    @else
                                                        12 Months
                                                    @endif
                                                </td>
                                                <td>
                                                    {{count(\App\Models\Rent::where('user_id',$member->user_id)->get())>0 ? \App\Models\Rent::where('user_id',$member->user_id)->get()->count() : 0}}
                                                    @if(count(\App\Models\Rent::where('user_id',$member->user_id)->get())>0)
                                                        <a href="{{route('user.rent',$member->user_id)}}" class="btn btn-sm btn-info ms-3"><i class="ri-eye-line"></i></a>
                                                @endif
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="show">
                                                            <a class="btn btn-sm btn-success show-item-btn" href="{{route('member.accept',$member->id)}}">Accept</a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" onclick="return deleteConfirm({{$member->id}})" class="btn btn-sm btn-danger remove-item-btn">Reject</button>
                                                        </div>
                                                        <form action="{{ route('member.destroy',$member->id)}}" class="d-none deleteForm{{$member->id}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>{{$member->created_at->format('Y-m-d')}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center h3">There is no member request !</td>
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



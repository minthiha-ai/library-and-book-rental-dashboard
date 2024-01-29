@extends('layouts.app')

@section('order')
    collapsed active
@endsection

@section('order-show')
    show
@endsection

@section('pending-order')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Pending Order</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Pending Order</li>
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
                                            <form action="{{ route('rent.pending') }}" method="get">
                                                <div class="d-flex">
                                                    <input type="text" class="form-control " name="search" placeholder="Search with phone number">
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
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Books</th>
                                            <th>Delivery Fees</th>
                                            <th>Status</th>
                                            <th>State</th>
                                            <th>Start Date</th>
                                            <th>OverDue Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @forelse ($data as $i => $item)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td><p class=" text-wrap">{!! $item->address !!}</p></td>
                                                    <td>
                                                        @foreach ($item->orderItems as $value)
                                                            {{ $value->book->code }},<br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $item->delivery_fee }} Kyats</td>
                                                    <td>
                                                        @switch($item->status)
                                                            @case('preorder')
                                                                    <div class="btn btn-sm rounded btn-secondary">preorder</div>
                                                                @break
                                                            @case('pending')
                                                                    <div class="btn btn-sm rounded btn-warning">pending</div>
                                                                @break
                                                            @case('success')
                                                                    <div class="btn btn-sm rounded btn-success">success</div>
                                                                @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        @switch($item->state)
                                                            @case('rented')
                                                                <div class="btn btn-sm rounded btn-warning">rented</div>
                                                                @break
                                                            @case('overdue')
                                                                <div class="btn btn-sm rounded btn-danger">overdue</div>
                                                                @break
                                                            @case('returned')
                                                                <div class="btn btn-sm rounded btn-success">returned</div>
                                                                @break
                                                            @default
                                                            <div class="btn btn-sm rounded btn-info">progressing</div>
                                                        @endswitch
                                                    </td>
                                                    <td>{{\Carbon\Carbon::parse($item->start_date)->format('Y-m-d')}}</td>
                                                    <td><span class=" text-danger">{{\Carbon\Carbon::parse($item->overdue_date)->format('Y-m-d')}}</span></td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <div class="edit">
                                                                <a class="btn btn-sm btn-success edit-item-btn" href="{{route('rent.show',$item->id)}}"><i class="ri-edit-line"></i></a>
                                                            </div>
                                                            <div class="remove">
                                                                <button type="button" onclick="return deleteConfirm({{$item->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                            </div>
                                                            <form action="{{ route('rent.destroy',$item->id)}}" class="d-none deleteForm{{$item->id}}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center h3">There is no renting book !</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{ $data->links('pagination::bootstrap-4') }}
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
        $(function (){
            $('.toggle-status').change(function() {
                var status = $(this).prop('checked') == true ? '1' : '0';
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/book-status',
                    data: {'status': status, 'id': id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })
        })
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
        $(".table").dataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $(".dataTables_length,.dataTables_filter,.dataTable,.dataTables_paginate,.dataTables_info").author().addClass(
            "px-0");
    </script>
@endsection



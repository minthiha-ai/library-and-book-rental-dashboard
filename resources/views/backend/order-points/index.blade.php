@extends('layouts.app')

@section('point')
    collapsed active
@endsection
@section('point-show')
    show
@endsection
@section('order-point-active')
    active
@endsection


@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Credit Point</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Credit Point</li>
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
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th class="sort" >User ID</th>
                                            <th class="sort" >point</th>
                                            <th class="sort" >price</th>
                                            <th class="sort" >payment</th>
                                            <th class="sort" >payment photo</th>
                                            <th class="sort" >status</th>
                                            <th class="sort" >Date</th>
                                            <th class="sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($data as $i=>$item)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>{{ $item->user?->userCode?->user_code }}</td>
                                                <td>
                                                    {{ $item->credit_point?->point }} @if ($item->credit_point?->point == 1) point @else points @endif
                                                </td>
                                                <td>
                                                    {{ $item->credit_point?->price }} Kyats
                                                </td>
                                                <td>
                                                    {{ $item->payment?->name }}
                                                </td>
                                                <td>
                                                    @if ($item->payment_photo != '')
                                                        <img src="{{asset('storage/images/payment/'.$item->payment_photo)}}" alt="" width="120" height="100">
                                                    @else
                                                        <img src="{{asset('images/logo.png')}}" alt="" width="120" height="100">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 0)
                                                        <div class="btn btn-sm rounded btn-warning">pending</div>
                                                    @else
                                                        <div class="btn btn-sm rounded btn-success">success</div>
                                                    @endif
                                                </td>
                                                <td>{{$item->created_at->format('Y-m-d')}}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <div class="edit">
                                                            <a class="btn btn-sm btn-success edit-item-btn" href="{{route('order-points.edit',$item->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" onclick="return deleteConfirm({{$item->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                        </div>
                                                        <form action="{{ route('order-points.destroy',$item->id)}}" class="d-none deleteForm{{$item->id}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center h3">There is no points !</td>
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
    </script>
@endsection



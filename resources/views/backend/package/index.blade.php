@extends('layouts.app')


@section('package')
    collapsed active
@endsection
@section('package-show')
    show
@endsection
@section('package-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Subscription Packages</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Subscription Package</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-gift-line me-2"></i>Subscription Packages</h5>
                        </div>
                        <div class="card-body">
                            <div id="customerList">
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('packages.create')}}" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                    </div>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort">#</th>
                                            <th class="sort">Image</th>
                                            <th class="sort">Title</th>
                                            <th class="sort">Duration</th>
                                            <th class="sort">Book per Rent</th>
                                            <th class="sort">Rent Duration</th>
                                            <th class="sort">Price</th>
                                            <th class="sort">Overdue price/day</th>
                                            <th class="sort">Overdue price/week</th>
                                            <th class="sort">Overdue price/month</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @forelse($data as $i=>$item)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @if ($item->image != '')
                                                        <img src="{{asset('storage/images/package/'.$item->image)}}" alt="" width="120" height="100">
                                                    @else
                                                        <img src="{{asset('images/logo.png')}}" alt="" width="120" height="100">
                                                    @endif
                                                    </td>
                                                    <td>{{$item->title}}</td>
                                                    <td>{{$item->package_duration}} days</td>
                                                    <td>{{$item->book_per_rent}} books</td>
                                                    <td>{{$item->rent_duration}} days</td>
                                                    <td>{{$item->price}} Kyats</td>
                                                    <td>{{$item->overdue_price_per_day}} Kyats</td>
                                                    <td>{{$item->overdue_price_per_week}} Kyats</td>
                                                    <td>{{$item->overdue_price_per_month}} Kyats</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <div class="edit">
                                                                <a class="btn btn-sm btn-success edit-item-btn" href="{{route('packages.edit',$item->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                            </div>
                                                            <div class="remove">
                                                                <button type="button" onclick="return deleteConfirm({{$item->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                            </div>
                                                            <form action="{{ route('packages.destroy', $item->id)}}" class="d-none deleteForm{{$item->id}}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center h3">There is no Package !</td>
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
    </script>
@endsection


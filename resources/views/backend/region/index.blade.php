@extends('layouts.app')

@section('region')
    collapsed active
@endsection
@section('region-show')
    show
@endsection
@section('region-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Regions</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Regions</li>
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
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{route('regions.create')}}" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="text-center no-sort">နာမည်</th>
                                            <th class="text-center no-sort">Cosh On Delivery</th>
                                            <th class="text-center no-sort no-search">ပြင်မည်/ဖျက်မည်</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($data as $i=>$item)
                                            <tr>
                                                <td>
                                                    {{ $item->name}}
                                                </td>
                                                <td>
                                                    @if ($item->cod == 1)
                                                    <div class="btn btn-sm rounded bg-soft-success">Yes</div>
                                                    @else
                                                    <div class="btn btn-sm rounded bg-soft-danger">No</div>
                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <div class="edit">
                                                            <a class="btn btn-sm btn-success edit-item-btn" href="{{route('regions.edit',$item->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" onclick="return deleteConfirm({{$item->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                        </div>
                                                        <form action="{{ route('regions.destroy',$item->id)}}" class="d-none deleteForm{{$item->id}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center h3">There is no Regions !</td>
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



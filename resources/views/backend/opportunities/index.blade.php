@extends('layouts.app')


@section('opportunity')
    collapsed active
@endsection
@section('opportunity-show')
    show
@endsection
@section('opportunity-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Member Opportunity</h4>

                        <div class="page-titlea-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Member Opportunity</li>
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
                            <h5 class="card-title mb-0"><i class="ri-gift-line me-2"></i>Opportunities</h5>
                        </div>
                        <div class="card-body">
                            <div id="customerList">
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('opportunities.create')}}" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                    </div>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th class="sort" >Member type</th>
                                            <th class="sort" >No: book</th>
                                            <th class="sort">Life time</th>
                                            <th class="sort">Overdue price/day</th>
                                            <th class="sort">Overdue price/week</th>
                                            <th class="sort">Overdue price/month</th>
                                            <th class="sort">Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @forelse($data as $i=>$opportunity)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>
                                                        @if($opportunity->member_type === '0')
                                                            3 Months
                                                        @elseif($opportunity->member_type === '1')
                                                            6 Months
                                                        @elseif($opportunity->member_type === '2')
                                                            1 year
                                                        @else
                                                            Normal
                                                        @endif
                                                    </td>
                                                    <td>{{$opportunity->no_of_book}}</td>
                                                    <td class="">{{$opportunity->life_time}}</td>
                                                    <td>{{$opportunity->overdue_price_per_day}}</td>
                                                    <td>{{$opportunity->overdue_price_per_week}}</td>
                                                    <td>{{$opportunity->overdue_price_per_month}}</td>
                                                    <td>{{$opportunity->created_at->format('Y-m-d')}}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <div class="edit">
                                                                <a class="btn btn-sm btn-success edit-item-btn" href="{{route('opportunities.edit',$opportunity->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                            </div>
                                                            <div class="remove">
                                                                <button type="button" onclick="return deleteConfirm({{$opportunity->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                            </div>
                                                            <form action="{{ route('opportunities.destroy', $opportunity->id)}}" class="d-none deleteForm{{$opportunity->id}}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center h3">There is no opportunity !</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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


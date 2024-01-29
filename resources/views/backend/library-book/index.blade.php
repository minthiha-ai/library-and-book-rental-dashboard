@extends('layouts.app')

@section('library-book')
    collapsed active
@endsection
@section('library-book-show')
    show
@endsection
@section('library-book-active')
    active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Books</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Books</li>
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
                                            <a href="{{route('library-book.create')}}" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="sort" >#</th>
                                            <th class="sort" >Title</th>
                                            <th class="sort" >Category</th>
                                            <th class="sort">Author</th>
                                            <th class="sort text-center">Cover</th>
                                            <th class="sort">No : Book</th>
                                            <th class="sort">Price</th>
                                            <th>Status</th>
                                            <th class="sort">Date</th>
                                            <th class="sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @forelse($books as $i=>$book)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>
                                                    {{\Illuminate\Support\Str::words($book->title,8)}}
                                                </td>
                                                <td>{{$book->category}}</td>
                                                <td>{{$book->author}}</td>
                                                <td class="text-center">
                                                    <img src="{{asset('storage/library-book/cover//'.$book->cover)}}" alt="" width="120" height="100">
                                                </td>
                                                <td>{{$book->no_of_book}}</td>
                                                <td>{{$book->price}}</td>
                                                <td class="fw-bold text-success">
                                                    @if($book->status === '0')
                                                        New Arrival
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{$book->created_at->format('Y-m-d')}}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="show">
                                                            <a class="btn btn-sm btn-info show-item-btn" href="{{route('library-book.show',$book->id)}}"><i class="ri-eye-line"></i></a>
                                                        </div>
                                                        <div class="edit">
                                                            <a class="btn btn-sm btn-success edit-item-btn" href="{{route('library-book.edit',$book->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" onclick="return deleteConfirm({{$book->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                        </div>
                                                        <form action="{{ route('library-book.destroy',$book->id)}}" class="d-none deleteForm{{$book->id}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center h3">There is no book !</td>
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



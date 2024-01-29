@extends('layouts.app')

@section('book')
    collapsed active
@endsection
@section('book-show')
    show
@endsection
@section('book-active')
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
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('book.create')}}" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Create</a>

                                        <button onclick="return importConfirm()" type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Import</button>

                                    </div>
                                    <form action="{{ route('book.index') }}" method="get">
                                        <div class="d-flex">
                                            <input type="text" class="form-control " name="search" placeholder="Search Book">
                                            <button class="btn btn-primary ml-2" type="submit"><i class="ri-search-line"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table text-center table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort">No.<th>
                                                <th>Book Id<th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Genres</th>
                                                <th>Author</th>
                                                <th>Cover</th>
                                                <th>No : Book</th>
                                                <th>Remain Book</th>
                                                <th>Credit Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @php
                                                $currentPage = request()->get('page', 1);
                                                $baseNumber = ($currentPage - 1) * $books->perPage();
                                            @endphp
                                            @forelse($books as $key => $book)
                                                <tr>
                                                    <td>{{ $baseNumber + ++$key }}</td>
                                                    <td></td>
                                                    <td>{{$book->code}}</td>
                                                    <td></td>
                                                    <td>
                                                        {{\Illuminate\Support\Str::words($book->title,8)}}
                                                    </td>
                                                    <td>{{ $book->category?->name }}</td>
                                                    <td>
                                                        @foreach($book->genres as $genre)
                                                            <span class="badge badge-soft-primary">{{ $genre->name }}</span><br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{$book->author}}</td>
                                                    <td class="text-center">
                                                        @if ($book->cover != '')
                                                            <img src="{{asset('storage/images/cover/'.$book->cover)}}" alt="" width="120" height="100">
                                                        @else
                                                            <img src="{{asset('images/logo.png')}}" alt="" width="120" height="100">
                                                        @endif
                                                    </td>
                                                    <td>{{$book->no_of_book}}</td>
                                                    <td>{{$book->remain}}</td>
                                                    <td>{{$book->credit_point}}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <div class="show">
                                                                <a class="btn btn-sm btn-info show-item-btn" href="{{route('book.show',$book->id)}}"><i class="ri-eye-line"></i></a>
                                                            </div>
                                                            <div class="edit">
                                                                <a class="btn btn-sm btn-success edit-item-btn" href="{{route('book.edit',$book->id)}}"><i class="ri-edit-circle-line"></i></a>
                                                            </div>
                                                            <div class="remove">
                                                                <button type="button" onclick="return deleteConfirm({{$book->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>
                                                            </div>
                                                            <form action="{{ route('book.destroy',$book->id)}}" class="d-none deleteForm{{$book->id}}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="13" class="text-center h3">There is no book !</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{ $books->links('pagination::bootstrap-4') }}
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
        function importConfirm() {
    Swal.fire({
        title: 'Import',
        html: `
            <form id="importForm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="fileInput">
            </form>
        `,
        showCancelButton: true,
        confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
        confirmButtonText: "Import",
        cancelButtonClass: "btn btn-danger w-xs mb-1",
        buttonsStyling: false,
        showCloseButton: true,
        preConfirm: () => {
            // Get the form data
            const formData = new FormData($('#importForm')[0]);

            // Make an AJAX request to handle the form submission
            $.ajax({
                url: "{{ route('import.books') }}",
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire(
                        'Imported!',
                        'The file has been imported successfully.',
                        'success'
                    );
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'An error occurred during the import.',
                        'error'
                    );
                }
            });
            location.reload();
        }
    });
}
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
        // $(".table").dataTable({
        //     "order": [
        //         [0, "desc"]
        //     ]
        // });
        // $(".dataTables_length,.dataTables_filter,.dataTable,.dataTables_paginate,.dataTables_info").author().addClass(
        //     "px-0");
    </script>
@endsection



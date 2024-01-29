@extends('layouts.app')

@section('rent-books')
    collapsed active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Rent Books</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Rent Books</li>
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
                                            <th class="sort" >Title</th>
                                            <th class="sort" >Category</th>
                                            <th class="sort">Author</th>
                                            <th class="sort text-center">Cover</th>
                                            <th>Remain</th>
                                            <th class="sort">Price</th>
                                            <th class="">Status</th>
                                            <th class="sort">Date</th>
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
                                                    <img src="{{asset('storage/book/cover//'.$book->cover)}}" alt="" width="120" height="100">
                                                </td>
                                                <td>{{$book->remain}}</td>
                                                <td>{{$book->price}}</td>
                                                <td class="fw-bold text-success">
                                                    New
                                                </td>
                                                <td>{{$book->created_at->format('Y-m-d')}}</td>
{{--                                                <td>--}}
{{--                                                    <div class="d-flex gap-2">--}}
{{--                                                        <div class="show">--}}
{{--                                                            <a class="btn btn-sm btn-info show-item-btn" href="{{route('book.show',$book->id)}}"><i class="ri-eye-line"></i></a>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="edit">--}}
{{--                                                            <a class="btn btn-sm btn-success edit-item-btn" href="{{route('book.edit',$book->id)}}"><i class="ri-edit-circle-line"></i></a>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="remove">--}}
{{--                                                            <button type="button" onclick="return deleteConfirm({{$book->id}})" class="btn btn-sm btn-danger remove-item-btn"><i class="ri-delete-bin-2-line"></i></button>--}}
{{--                                                        </div>--}}
{{--                                                        <form action="{{ route('book.destroy',$book->id)}}" class="d-none deleteForm{{$book->id}}" method="POST">--}}
{{--                                                            @method('DELETE')--}}
{{--                                                            @csrf--}}
{{--                                                        </form>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
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
        $(".table").dataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $(".dataTables_length,.dataTables_filter,.dataTable,.dataTables_paginate,.dataTables_info").author().addClass(
            "px-0");
    </script>
@endsection



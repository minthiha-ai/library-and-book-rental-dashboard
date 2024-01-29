@extends('layouts.app')

@section('rent-history')
    collapsed active
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Rent Detail</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Rent Detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @include('partials.msg')
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('rent.update',$data->id) }}" method="post" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-edit-line me-2"></i>Rent Detail</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class=" table table-bordered table-responsive">
                                            <tr>
                                                <td>Username</td>
                                                <td>{{ $data->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>{{ $data->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $data->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Region</td>
                                                <td>{{ $data->region?->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Township</td>
                                                <td>{{ $data->deliveryFee?->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>Delivery Fee</td>
                                                <td>{{ $data->deliveryFee?->fee }}</td>
                                            </tr>
                                            <tr>
                                                <td>Books</td>
                                                <td>
                                                    @foreach ($data->orderItems as $value)
                                                        {{ $value->book->code }},
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class=" table table-bordered table-responsive">
                                            <tr>
                                                <td>Start Date</td>
                                                <td>
                                                    @if ($data->start_date != null)
                                                        {{ Carbon\Carbon::parse($data->start_date)->format('d/m/Y H:i') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Overdue Date</td>
                                                <td>
                                                    @if ($data->overdue_date != null)
                                                        {{ Carbon\Carbon::parse($data->overdue_date)->format('d/m/Y H:i') }}
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Return Date</td>
                                                <td>
                                                    @if ($data->return_date != null)
                                                        {{ Carbon\Carbon::parse($data->return_date)->format('d/m/Y H:i') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <select name="status" class="form-control select2">
                                                        <option value="preorder" {{ ($data->status == 'preorder' ) ? 'selected': '' }}>preorder</option>
                                                        <option value="pending" {{ ($data->status == 'pending' ) ? 'selected': '' }}>pending</option>
                                                        <option value="success" {{ ($data->status == 'success' ) ? 'selected': '' }}>complete</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>State</td>
                                                <td>{{ $data->state }}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div class="text-end mb-3">
                                    <a href="{{ route('rent.index') }}" class="btn btn-warning w-sm">Back</a>
                                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
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
    $(document).ready(function() {
            $('.select2').select2();
    });
</script>
@endsection



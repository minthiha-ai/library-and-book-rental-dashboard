@extends('layouts.app')
@section('setting')
    collapsed active
@endsection
@section('setting')
    show
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Settings</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">Setting</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Settings</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Change Returnable Day</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="day" id="day" value="{{ $days->day }}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Days</span>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($data as $item)
                                        <div class="col-12 mt-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" onchange="settingChange({{ $item->id }})" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $item->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Returnable before {{ $days->day }} days</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        const settingChange = (id) => {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type:'POST',
                url:`/settings/change/${id}`,

                success:function(data) {
                    Toast.fire({ icon: "success", title : 'success' });
                },

                error: function (msg) {
                    console.log(msg);
                    var errors = msg.responseJSON;
                }
            });
            };
            const day = document.getElementById('day');
            day.addEventListener('keydown',(event)=>{
                if(event.key === 'Enter'){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type:'POST',
                        url:`/settings/change-day`,
                        data:{day:day.value},

                        success:function(data) {
                            console.log(data);
                            Toast.fire({ icon: "success", title : 'success' });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },

                        error: function (msg) {
                            console.log(msg);
                            var errors = msg.responseJSON;
                        }
                    });
                }
            });
    </script>
@endsection

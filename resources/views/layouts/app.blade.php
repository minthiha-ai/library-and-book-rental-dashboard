<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>

    <meta charset="utf-8" />
    <title>Wisdom Tree Library | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <!-- jsvectormap css -->
    <link href='{{ asset("assets/libs/jsvectormap/css/jsvectormap.min.css") }}' rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href='{{ asset("assets/libs/swiper/swiper-bundle.min.css") }}' rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src='{{ asset("assets/js/layout.js") }}'></script>
    <!-- Bootstrap Css -->
    <link href='{{ asset("assets/css/bootstrap.min.css") }}' rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href='{{ asset("assets/css/icons.min.css") }}' rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href='{{ asset("assets/css/app.min.css") }}' rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href='{{ asset("assets/css/custom.min.css") }}' rel="stylesheet" type="text/css" />
    <!-- Sweet Alert css-->
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">

    <!-- Datatable -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- image upload-->
    <link href="{{ asset('assets/uploader/dist/image-uploader.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/uploader/src/image-uploader.css') }}">
    <!-- datetime picker -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('assets/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <style>
        .slow  .switch-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
    </style>

    @yield('style')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

@include('layouts.header')
<!-- ========== App Menu ========== -->
@include('layouts.sidebar')
<!-- Left Sidebar End -->

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

    @yield('content')
    <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!-- JAVASCRIPT -->
<script src='{{ asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js") }}'></script>
<script src='{{ asset("assets/libs/simplebar/simplebar.min.js") }}'></script>
<script src='{{ asset("assets/libs/node-waves/waves.min.js") }}'></script>
<script src='{{ asset("assets/libs/feather-icons/feather.min.js") }}'></script>
<script src='{{ asset("assets/js/pages/plugins/lord-icon-2.1.0.js") }}'></script>
<script src='{{ asset("assets/js/plugins.js") }}'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<script crossorigin="anonymous" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
></script>

<!-- apexcharts -->
<script src='{{ asset("assets/libs/apexcharts/apexcharts.min.js") }}'></script>

<!-- Vector map-->
<script src='{{ asset("assets/libs/jsvectormap/js/jsvectormap.min.js") }}'></script>
<script src='{{ asset("assets/libs/jsvectormap/maps/world-merc.js") }}'></script>

<!--Swiper slider js-->
<script src='{{ asset("assets/libs/swiper/swiper-bundle.min.js") }}'></script>

<!-- Dashboard init -->
<script src='{{ asset("assets/js/pages/dashboard-ecommerce.init.js") }}'></script>

<!-- Sweet Alerts js -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Sweet alert init js-->
<script src="{{asset('assets/js/pages/sweetalerts.init.js')}}"></script>

{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- App js -->
<script src='{{ asset("assets/js/app.js") }}'></script>

<!-- image upload-->
<script src="{{ asset('assets/uploader/dist/image-uploader.min.js') }}"></script>
<script src="{{ asset('assets/uploader/src/image-uploader.js') }}"></script>
<!-- datetime picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
<script src="{{ asset('assets/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
@yield('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        // message
        const message = (status, message) => {
            Toast.fire({
                    icon: status,
                    title: message,
                });
        };
    </script>

    @if (Session::has('success'))
        <script>
            Toast.fire({
                icon: "success",
                title: @json(session()->pull('success')),
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Toast.fire({
                icon: "error",
                title: @json(session()->pull('error')),
            });
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Toast.fire({
                    icon: "error",
                    title: "{{ $error }}",
                });
            </script>
        @endforeach
    @endif
</body>
</html>

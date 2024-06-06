<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ config('settings.main.1_app_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('settings.main.1_app_name') }}" name="author" />
    <meta content="{{ config('settings.main.2_app_description') }}" style="border-radius: 20px" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Storage::url('public/setting'.'/'.config('settings.main.3_app_logo')) }}">
    @include('layouts.head-css')
</head>

@section('body')

<body data-sidebar="dark">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    @include('sweetalert::alert')
</body>

</html>